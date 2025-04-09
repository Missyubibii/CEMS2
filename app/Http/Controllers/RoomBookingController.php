<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\Room;
use App\Models\User;
use App\Models\Period;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomBookingController extends Controller
{
    public function timetable()
    {
        $roomBookings = RoomBooking::with(['room', 'startPeriod', 'endPeriod', 'user', 'devices'])
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return view('room_bookings.timetable', compact('roomBookings'));
    }

    // Rest of the controller code remains the same
    private function checkRoomConflict($roomId, $bookingDate, $startPeriodId, $endPeriodId, $excludeBookingId = null)
    {
        $query = RoomBooking::where('room_id', $roomId)
            ->where('booking_date', $bookingDate)
            ->where(function ($query) use ($startPeriodId, $endPeriodId) {
                $query->whereBetween('start_period_id', [$startPeriodId, $endPeriodId])
                    ->orWhereBetween('end_period_id', [$startPeriodId, $endPeriodId])
                    ->orWhere(function ($query) use ($startPeriodId, $endPeriodId) {
                        $query->where('start_period_id', '<=', $startPeriodId)
                            ->where('end_period_id', '>=', $endPeriodId);
                    });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->exists();
    }

    public function create()
    {
        $rooms = Room::all();
        $periods = Period::all();
        $devices = Device::all();
        $bookDevice = old('book_device', 'no');
        return view('room_bookings.store', compact('rooms', 'periods', 'devices', 'bookDevice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id',
            'purpose' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'book_device' => 'required|in:yes,no',
            'devices' => 'required_if:book_device,yes|array',
            'device_quantity' => 'required_if:book_device,yes|array'
        ]);

        if ($this->checkRoomConflict(
            $request->room_id,
            $request->booking_date,
            $request->start_period_id,
            $request->end_period_id
        )) {
            return redirect()->back()->withErrors(['error' => 'Phòng đã được đặt trong khoảng thời gian này.']);
        }

        try {
            DB::beginTransaction();

            if ($request->book_device === 'yes' && $request->has('devices')) {
                foreach ($request->devices as $deviceId => $checked) {
                    $quantity = $request->device_quantity[$deviceId] ?? 0;
                    if ($quantity > 0) {
                        $device = Device::find($deviceId);
                        if (!$device || $device->quantity < $quantity) {
                            DB::rollBack();
                            return redirect()->back()->withErrors([
                                'devices' => "Số lượng thiết bị {$device->device_name} không đủ."
                            ]);
                        }
                    }
                }
            }

            $roomBooking = RoomBooking::create([
                'user_id' => auth()->id(),
                'room_id' => $request->room_id,
                'start_period_id' => $request->start_period_id,
                'end_period_id' => $request->end_period_id,
                'booking_date' => $request->booking_date,
                'purpose' => $request->purpose,
                'status' => 'Chờ duyệt',
            ]);

            if ($request->book_device === 'yes' && $request->has('devices')) {
                foreach ($request->devices as $deviceId => $checked) {
                    $quantity = $request->device_quantity[$deviceId] ?? 0;
                    if ($quantity > 0) {
                        $roomBooking->devices()->attach($deviceId, ['quantity' => $quantity]);
                    }
                }
            }

            $this->updateRoomStatus($request->room_id);

            DB::commit();

            return redirect()->route('room_bookings.timetable')
                ->with('success', 'Đơn đặt phòng đã được tạo thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra khi tạo đơn đặt phòng.']);
        }
    }

    public function edit($id)
    {
        $roomBooking = RoomBooking::findOrFail($id);
        $rooms = Room::all();
        $periods = Period::all();
        $devices = Device::all();
        return view('room_bookings.edit', compact('roomBooking', 'rooms', 'periods', 'devices'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id',
            'purpose' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'book_device' => 'required|in:yes,no',
            'devices' => 'required_if:book_device,yes|array',
            'device_quantity' => 'required_if:book_device,yes|array'
        ]);

        $booking = RoomBooking::findOrFail($id);

        if ($this->checkRoomConflict(
            $request->room_id,
            $request->booking_date,
            $request->start_period_id,
            $request->end_period_id,
            $id
        )) {
            return redirect()->back()->withErrors(['error' => 'Phòng đã được đặt trong khoảng thời gian này.']);
        }

        try {
            DB::beginTransaction();

            if ($request->book_device === 'yes' && $request->has('devices')) {
                foreach ($request->devices as $deviceId => $checked) {
                    $quantity = $request->device_quantity[$deviceId] ?? 0;
                    if ($quantity > 0) {
                        $device = Device::find($deviceId);
                        $currentBookedQuantity = $booking->devices->where('id', $deviceId)->first()?->pivot->quantity ?? 0;
                        $availableQuantity = $device->quantity + $currentBookedQuantity;

                        if (!$device || $availableQuantity < $quantity) {
                            DB::rollBack();
                            return redirect()->back()->withErrors([
                                'devices' => "Số lượng thiết bị {$device->device_name} không đủ."
                            ]);
                        }
                    }
                }
            }

            $booking->update([
                'room_id' => $request->room_id,
                'start_period_id' => $request->start_period_id,
                'end_period_id' => $request->end_period_id,
                'booking_date' => $request->booking_date,
                'purpose' => $request->purpose,
            ]);

            $booking->devices()->detach();
            if ($request->book_device === 'yes' && $request->has('devices')) {
                foreach ($request->devices as $deviceId => $checked) {
                    $quantity = $request->device_quantity[$deviceId] ?? 0;
                    if ($quantity > 0) {
                        $booking->devices()->attach($deviceId, ['quantity' => $quantity]);
                    }
                }
            }

            $this->updateRoomStatus($request->room_id);

            DB::commit();

            return redirect()->route('room_bookings.timetable')
                ->with('success', 'Cập nhật đơn đặt phòng thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật đơn đặt phòng.']);
        }
    }

    public function destroy($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $roomId = $booking->room_id;

        if ($booking->status === 'Đang sử dụng') {
            try {
                DB::beginTransaction();

                foreach ($booking->devices as $device) {
                    $device->increment('quantity', $device->pivot->quantity);
                }

                $booking->delete();
                $this->updateRoomStatus($roomId);

                DB::commit();

                return redirect()->route('room_bookings.timetable')
                    ->with('success', 'Đã xóa đơn đặt phòng và hoàn lại số lượng thiết bị thành công.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra khi xóa đơn đặt phòng.']);
            }
        } else {
            $booking->delete();
            $this->updateRoomStatus($roomId);

            return redirect()->route('room_bookings.timetable')
                ->with('success', 'Đã xóa đơn đặt phòng thành công.');
        }
    }

    private function updateRoomStatus($roomId)
    {
        $activeBooking = RoomBooking::where('room_id', $roomId)
            ->where('status', 'Đang sử dụng')
            ->exists();

        $room = Room::findOrFail($roomId);

        if ($activeBooking) {
            $room->update(['status' => 'Đang sử dụng']);
        } else {
            $room->update(['status' => 'Còn trống']);
        }
    }
}
