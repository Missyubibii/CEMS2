<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\Room;
use App\Models\Period;
use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoomBookingController extends Controller
{
    public function index()
    {
        $roomBookings = RoomBooking::with('user', 'room', 'startPeriod', 'endPeriod')->get();
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
            $roomBooking->update(['status' => 'Đang sử dụng']);
            return redirect()->route('admin.room_bookings.index')->with('success', 'Đơn đặt phòng đã được duyệt.');
        }

        return redirect()->route('admin.room_bookings.index')->with('error', 'Đơn đặt phòng không thể duyệt.');
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
        $roomBooking->update([
            'status' => 'Đã trả phòng',
            'room_status' => 'Còn trống'
        ]);

        return redirect()->route('admin.room_bookings.index')->with('success', 'Phòng đã được trả.');
    }

}


