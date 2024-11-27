<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('admin.devices.index', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
            'status' => 'required|in:Chưa sử dụng,Đang sử dụng,Đang bảo trì,Hỏng hóc',
        ]);

        Device::create($request->all());

        return redirect()->route('admin.devices.index')->with('success', 'Thiết bị đã được thêm thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa thiết bị.
     */
    public function edit(Device $device)
    {
        return view('admin.devices.edit', compact('device'));
    }

    /**
     * Cập nhật thông tin thiết bị.
     */
    public function update(Request $request, Device $device)
    {
        // Validate dữ liệu
        $request->validate([
            'device_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        // Cập nhật thiết bị
        $device->update([
            'device_name' => $request->input('device_name'),
            'category' => $request->input('category'),
            'quantity' => $request->input('quantity'),
            'status' => $request->input('status'),
        ]);

        // Chuyển hướng về trang quản lý thiết bị với thông báo thành công
        return redirect()->route('admin.devices.index')->with('status', 'profile-updated');
    }


    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('admin.devices.index')->with('success', 'Thiết bị đã được xóa.');
    }
}
