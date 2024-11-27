<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\RoomAddress;
use App\Models\RoomBooking;

class RoomBookingController extends Controller
{
    public function index()
    {
        // Lấy tất cả các đơn đặt phòng với thông tin liên quan và phân trang
        $roomBookings = RoomBooking::with(['user', 'room', 'roomAddress'])->paginate(10); // Phân trang 10 đơn mỗi trang

        // Truyền dữ liệu vào view
        $rooms = Room::all();
        $users = User::all();
        $roomAddresses = RoomAddress::all();

        return view('admin.room_bookings.index', compact('roomBookings', 'rooms', 'users', 'roomAddresses'));
    }

    public function create()
    {
        // Không cần tạo action riêng cho create, vì form sẽ nằm trong trang index
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'room_id' => 'required',
            'room_address_id' => 'required',
            'time_slot' => 'required',
        ]);

        RoomBooking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'room_address_id' => $request->room_address_id,
            'time_slot' => $request->time_slot,
            'status' => 'Chờ duyệt', // Mặc định trạng thái là "Chờ duyệt"
        ]);

        return redirect()->route('admin.room_bookings.index');
    }

    public function edit($id)
    {
        // Lấy thông tin đơn đặt phòng để chỉnh sửa
        $roomBooking = RoomBooking::findOrFail($id);
        $rooms = Room::all();
        $users = User::all();
        $roomAddresses = RoomAddress::all();

        return view('admin.room_bookings.edit', compact('roomBooking', 'rooms', 'users', 'roomAddresses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'room_id' => 'required',
            'room_address_id' => 'required',
            'time_slot' => 'required',
        ]);

        $roomBooking = RoomBooking::findOrFail($id);
        $roomBooking->update([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'room_address_id' => $request->room_address_id,
            'time_slot' => $request->time_slot,
            'status' => $request->status, // Cập nhật trạng thái nếu cần
        ]);

        return redirect()->route('admin.room_bookings.index');
    }

    public function destroy($id)
    {
        $roomBooking = RoomBooking::findOrFail($id);
        $roomBooking->delete();

        return redirect()->route('admin.room_bookings.index');
    }

    public function updateStatus($id, $status)
    {
        $roomBooking = RoomBooking::findOrFail($id);
        $roomBooking->status = $status;
        $roomBooking->save();

        return redirect()->route('admin.room_bookings.index');
    }
}


