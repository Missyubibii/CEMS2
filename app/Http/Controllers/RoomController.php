<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomAddress;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        // Phân trang phòng học, mỗi trang 5 phòng học
        $rooms = Room::with('roomAddress')->paginate(5);

        // Phân trang địa chỉ phòng học, mỗi trang 5 địa chỉ
        $roomAddresses = RoomAddress::paginate(5);

        // Trả dữ liệu sang view
        return view('admin.rooms.index', compact('rooms', 'roomAddresses'));
    }


    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'room_name' => 'required|string|max:255',
            'room_address_id' => 'required|exists:room_addresses,id',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:Còn trống,Đang sử dụng,Đang bảo trì',
        ]);

        // Tạo phòng học mới
        Room::create([
            'room_name' => $request->room_name,
            'room_address_id' => $request->room_address_id, // Lưu giá trị room_address_id
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        // dd($request->all());

        // Redirect về danh sách với thông báo
        return redirect()->route('admin.rooms.index')->with('success', 'Thêm phòng học thành công!');
    }

    public function edit(Room $room)
    {
        // Lấy tất cả địa chỉ phòng học
        $roomAddresses = RoomAddress::with(['building', 'campus'])->get();

        // Truyền biến $room và $roomAddresses vào view
        return view('admin.rooms.edit', compact('room', 'roomAddresses'));
    }

    public function update(Request $request, Room $room)
    {
        // Validate dữ liệu
        $request->validate([
            'room_name' => 'required|string|max:255',
            'room_address_id' => 'required|exists:room_addresses,id',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string|in:Còn trống,Đang sử dụng,Đang bảo trì',
        ]);

        // Cập nhật thông tin phòng học
        $room->update([
            'room_name' => $request->room_name,
            'room_address_id' => $request->room_address_id,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        // Redirect về danh sách phòng học
        return redirect()->route('admin.rooms.index')->with('success', 'Cập nhật thông tin phòng học thành công!');
    }

    public function destroy(Room $room)
    {
        // Xóa phòng học
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Xóa phòng học thành công!');
    }
}
