<?php

namespace App\Http\Controllers;

use App\Models\RoomAddress;
use App\Models\Building;
use App\Models\Campus;
use Illuminate\Http\Request;

class RoomAddressController extends Controller
{
    public function index()
    {
        // Lấy danh sách địa chỉ phòng học
        $roomAddresses = RoomAddress::with(['building', 'campus'])->get();

        // Lấy danh sách tòa nhà và cơ sở
        $buildings = Building::all();
        $campuses = Campus::all();

        // Truyền tất cả dữ liệu vào view
        return view('admin.room_addresses.index', compact('roomAddresses', 'buildings', 'campuses'));
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'room_name' => 'required|string',
            'building_id' => 'required|exists:buildings,id',
            'campus_id' => 'required|exists:campuses,id',
        ]);

        // Store room address
        RoomAddress::create([
            'room_name' => $request->room_name,
            'building_id' => $request->building_id,
            'campus_id' => $request->campus_id,
        ]);

        // Redirect to the index page after saving
        return redirect()->route('admin.room_addresses.index')->with('success', 'Địa chỉ đã được thêm thành công.');
    }

    public function edit(RoomAddress $roomAddress)
    {
        $buildings = Building::all(); // Lấy danh sách tòa nhà
        $campuses = Campus::all();   // Lấy danh sách cơ sở

        return view('admin.room_addresses.edit', compact('roomAddress', 'buildings', 'campuses'));
    }

    // public function create()
    // {
    //     // Fetch buildings and campuses
    //     $buildings = Building::all();
    //     $campuses = Campus::all();

    //     return view('admin.room_addresses.create', compact('buildings', 'campuses'));
    // }

    public function update(Request $request, RoomAddress $roomAddress)
    {
        $request->validate([
            'room_name' => 'required|string',
            'building_id' => 'required|exists:buildings,id',
            'campus_id' => 'required|exists:campuses,id',
        ]);

        $roomAddress->update($request->only('room_name', 'building_id', 'campus_id'));

        return redirect()->route('admin.room_addresses.index')->with('success', 'Địa chỉ đã được cập nhật.');
    }


    public function destroy(RoomAddress $roomAddress)
    {
        $roomAddress->delete();
        return redirect()->route('admin.room_addresses.index')->with('success', 'Địa chỉ đã được xóa.');
    }
}

