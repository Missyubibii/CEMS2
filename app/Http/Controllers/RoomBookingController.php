<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\Room;
use App\Models\User;
use App\Models\Period;
use App\Models\Device;
use Illuminate\Http\Request;

class RoomBookingController extends Controller
{
    public function timetable()
    {
        $roomBookings = RoomBooking::with(['room', 'startPeriod', 'endPeriod', 'user', 'devices'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('room_bookings.timetable', compact('roomBookings'));
    }

    // Kiểm tra đơn đặt phòng trùng lặp
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

    // Hiển thị form tạo mới đơn đặt phòng
    public function create()
    {
        $rooms = Room::all();
        $periods = Period::all();
        $devices = Device::all();
        $bookDevice = old('book_device', 'no'); // Giá trị mặc định là 'no'
        return view('room_bookings.store', compact('rooms', 'periods', 'devices', 'bookDevice'));
    }

    // Lưu đơn đặt phòng mới
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'room_id' => 'required|exists:rooms,id',
    //         'start_period_id' => 'required|exists:periods,id',
    //         'end_period_id' => 'required|exists:periods,id',
    //         'purpose' => 'required|string|max:255',
    //         'booking_date' => 'required|date',
    //     ]);

    //     if (
    //         $this->checkRoomConflict(
    //             $request->room_id,
    //             $request->booking_date,
    //             $request->start_period_id,
    //             $request->end_period_id
    //         )
    //     ) {
    //         return redirect()->back()->withErrors(['error' => 'Phòng đã được đặt trong khoảng thời gian này.']);
    //     }

    //     RoomBooking::create([
    //         'user_id' => $request->user_id,
    //         'room_id' => $request->room_id,
    //         'start_period_id' => $request->start_period_id,
    //         'end_period_id' => $request->end_period_id,
    //         'booking_date' => $request->booking_date,
    //         'purpose' => $request->purpose,
    //         'status' => 'Chờ duyệt',
    //     ]);

    //     // Cập nhật trạng thái phòng
    //     $this->updateRoomStatus($request->room_id);

    //     return redirect()->route('room_bookings.timetable')
    //         ->with('success', 'Đơn đặt phòng đã được tạo thành công.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id',
            'purpose' => 'required|string|max:255',
            'booking_date' => 'required|date',
        ]);

        if (
            $this->checkRoomConflict(
                $request->room_id,
                $request->booking_date,
                $request->start_period_id,
                $request->end_period_id
            )
        ) {
            return redirect()->back()->withErrors(['error' => 'Phòng đã được đặt trong khoảng thời gian này.']);
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

        if ($request->book_device === 'yes') {
            foreach ($request->devices as $deviceId => $device) {
                $roomBooking->devices()->attach($deviceId, ['quantity' => $request->device_quantity[$deviceId]]);
            }
        }

        $this->updateRoomStatus($request->room_id);

        return redirect()->route('room_bookings.timetable')
            ->with('success', 'Đơn đặt phòng đã được tạo thành công.');
    }

    // Hiển thị form chỉnh sửa đơn đặt phòng
    public function edit($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $rooms = Room::all();
        $periods = Period::all();
        $devices = Device::all();
        return view('room_bookings.edit', compact('booking', 'rooms', 'periods', 'devices'));
    }

    // Cập nhật đơn đặt phòng
    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id',
            'purpose' => 'required|string|max:255',
            'booking_date' => 'required|date',
        ]);

        $booking = RoomBooking::findOrFail($id);

        if (
            $this->checkRoomConflict(
                $request->room_id,
                $request->booking_date,
                $request->start_period_id,
                $request->end_period_id,
                $id
            )
        ) {
            return redirect()->back()->withErrors(['error' => 'Phòng đã được đặt trong khoảng thời gian này.']);
        }

        $booking->update([
            'room_id' => $request->room_id,
            'start_period_id' => $request->start_period_id,
            'end_period_id' => $request->end_period_id,
            'booking_date' => $request->booking_date,
            'purpose' => $request->purpose,
        ]);

        // Cập nhật trạng thái phòng
        $this->updateRoomStatus($request->room_id);

        return redirect()->route('room_bookings.timetable')
            ->with('success', 'Cập nhật đơn đặt phòng thành công.');
    }

    // Xóa đơn đặt phòng
    public function destroy($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $roomId = $booking->room_id;

        $booking->delete();

        // Cập nhật trạng thái phòng
        $this->updateRoomStatus($roomId);

        return redirect()->route('room_bookings.timetable')
            ->with('success', 'Đã xóa đơn đặt phòng thành công.');
    }

    // Cập nhật trạng thái phòng
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
