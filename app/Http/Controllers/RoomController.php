<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(5);
        // Lấy danh sách tòa nhà và cơ sở
        $buildings = Building::all();
        $campuses = Campus::all();

        // Trả dữ liệu sang view
        return view('admin.rooms.index', compact('rooms', 'buildings', 'campuses'));
    }

    public function create()
    {
        $buildings = Building::all();
        $campuses = Campus::all();

        return view('admin.rooms.store', compact('buildings', 'campuses'));
    }

    public function store(Request $request)
    {
        // Kiểm tra nếu phòng học đã tồn tại trong cùng tòa học và cơ sở
        $request->validate([
            'room_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms')->where(function ($query) use ($request) {
                    return $query->where('building_id', $request->building_id)
                                 ->where('campus_id', $request->campus_id);
                }),
            ],
            'building_id' => 'required|exists:buildings,id',
            'campus_id' => 'required|exists:campuses,id',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:Còn trống,Đang sử dụng,Đang bảo trì',
        ], [
            'room_name.unique' => 'Tên phòng học đã tồn tại trong Tòa học và Cơ sở này. Vui lòng nhập tên khác.',
        ]);

        // Tạo phòng học mới
        Room::create([
            'room_name' => $request->room_name,
            'building_id' => $request->building_id,
            'campus_id' => $request->campus_id,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        // Redirect về danh sách với thông báo
        return redirect()->route('admin.rooms.index')->with('success', 'Thêm phòng học thành công!');
    }

    public function edit(Room $room)
    {
        // Lấy tất cả địa chỉ phòng học
        // $roomAddresses = RoomAddress::with(['building', 'campus'])->get();
        $buildings = Building::all(); // Lấy danh sách tòa nhà
        $campuses = Campus::all();   // Lấy danh sách cơ sở

        // Truyền biến $room và $roomAddresses vào view
        return view('admin.rooms.edit', compact('room', 'buildings', 'campuses'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'room_name')->ignore($room->id),
            ],
            'building_id' => 'required|exists:buildings,id',
            'campus_id' => 'required|exists:campuses,id',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string|in:Còn trống,Đang sử dụng,Đang bảo trì',
        ], [
            'room_name.unique' => 'Tên phòng đã tồn tại. Vui lòng nhập tên khác.',
        ]);

        // Cập nhật thông tin phòng
        $room->update($request->all());

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Thông tin phòng đã được cập nhật thành công!');
    }


    public function destroy(Room $room)
    {
        // Xóa phòng học
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Xóa phòng học thành công!');
    }
}
