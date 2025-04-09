<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\Room;
use App\Models\Period;
use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminRoomBookingController extends Controller
{
    public function index()
    {
        $roomBookings = RoomBooking::with(['user', 'room', 'startPeriod', 'endPeriod', 'devices'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.room_bookings.index', compact('roomBookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'Còn trống')->get();
        $periods = Period::all();
        $devices = Device::all();
        return view('admin.room_bookings.create', compact('rooms', 'periods', 'devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id',
            'booking_date' => 'required|date',
            'purpose' => 'required|string',
            'status' => 'required|string|in:Chờ duyệt,Từ chối duyệt,Đang sử dụng,Đã trả phòng',
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devices,id',
            'devices.*.quantity' => 'required|integer|min:1',
        ]);

        $room = Room::find($request->room_id);
        if ($room && $room->status !== 'Còn trống') {
            return redirect()->back()->withErrors(['room_id' => 'Phòng học không còn trống.']);
        }

        $existingBooking = RoomBooking::where('room_id', $request->room_id)
            ->where('booking_date', $request->booking_date)
            ->where(function($query) use ($request) {
                $query->where('start_period_id', '<=', $request->end_period_id)
                      ->where('end_period_id', '>=', $request->start_period_id);
            })
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->withErrors(['room_id' => 'Phòng học đã được đặt trong thời gian này.']);
        }

        // Tạo mới đơn đặt phòng
        $roomBooking = RoomBooking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'start_period_id' => $request->start_period_id,
            'end_period_id' => $request->end_period_id,
            'booking_date' => $request->booking_date,
            'purpose' => $request->purpose,
            'status' => 'Chờ duyệt',
        ]);

        // Gắn thiết bị cho đơn đặt phòng nếu có
        if ($request->has('devices')) {
            foreach ($request->devices as $deviceId => $quantity) {
                $device = Device::find($deviceId);
                if (!$device || $device->quantity < $quantity) {
                    return redirect()->back()->withErrors(['devices' => "Số lượng thiết bị không đủ."]);
                }
                $roomBooking->devices()->attach($deviceId, ['quantity' => $quantity]);
            }
        }

        return redirect()->route('admin.room_bookings.index')->with('success', 'Đặt phòng thành công!');
    }

    public function edit(RoomBooking $roomBooking)
    {
        $users = User::all();
        $rooms = Room::all();
        $periods = Period::all();
        return view('admin.room_bookings.edit', compact('roomBooking', 'users', 'rooms', 'periods'));
    }

    public function update(Request $request, RoomBooking $roomBooking)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id',
            'booking_date' => 'required|date',
            'purpose' => 'required|string',
        ]);

        $roomBooking->update([
            'room_id' => $request->room_id,
            'start_period_id' => $request->start_period_id,
            'end_period_id' => $request->end_period_id,
            'booking_date' => $request->booking_date,
            'purpose' => $request->purpose,
        ]);
        return redirect()->route('admin.room_bookings.index')->with('success', 'Cập nhật đơn đặt phòng thành công!');
    }

    public function approve(RoomBooking $roomBooking)
    {
        if ($roomBooking->status === 'Chờ duyệt') {
            try {
                DB::beginTransaction();

                // Check device quantities
                foreach ($roomBooking->devices as $device) {
                    if ($device->quantity < $device->pivot->quantity) {
                        DB::rollBack();
                        return redirect()->route('admin.room_bookings.index')
                            ->with('error', "Số lượng thiết bị {$device->device_name} không đủ.");
                    }

                    // Deduct quantities
                    $device->decrement('quantity', $device->pivot->quantity);
                }

                $roomBooking->update(['status' => 'Đang sử dụng']);
                DB::commit();

                return redirect()->route('admin.room_bookings.index')
                    ->with('success', 'Đơn đặt phòng đã được duyệt và số lượng thiết bị đã được cập nhật.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('admin.room_bookings.index')
                    ->with('error', 'Có lỗi xảy ra khi duyệt đơn đặt phòng.');
            }
        }

        return redirect()->route('admin.room_bookings.index')
            ->with('error', 'Đơn đặt phòng không thể duyệt.');
    }

    public function reject(RoomBooking $roomBooking)
    {
        if ($roomBooking->status === 'Chờ duyệt') {
            $roomBooking->update([
                'status' => 'Từ chối duyệt',
                'room_status' => 'Còn trống'
            ]);
            return redirect()->route('admin.room_bookings.index')->with('success', 'Đơn đặt phòng đã bị từ chối.');
        }

        return redirect()->route('admin.room_bookings.index')->with('error', 'Đơn đặt phòng không thể từ chối.');
    }

    public function returnRoom(RoomBooking $roomBooking)
    {
        try {
            DB::beginTransaction();

            // Return device quantities if there were any devices booked
            foreach ($roomBooking->devices as $device) {
                $device->increment('quantity', $device->pivot->quantity);
            }

            $roomBooking->update([
                'status' => 'Đã trả phòng',
                'room_status' => 'Còn trống'
            ]);

            DB::commit();

            return redirect()->route('admin.room_bookings.index')
                ->with('success', 'Phòng đã được trả và số lượng thiết bị đã được hoàn lại.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.room_bookings.index')
                ->with('error', 'Có lỗi xảy ra khi trả phòng.');
        }
    }
}
