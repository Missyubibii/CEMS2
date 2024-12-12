<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Device;
use App\Models\Period;
use App\Models\RoomBooking;
use Illuminate\Http\Request;

class RoomBookingController extends Controller
{
    public function index()
    {
        $roomBookings = RoomBooking::with(['user', 'room', 'startPeriod', 'endPeriod', 'devices'])
            ->paginate(5);
        $rooms = Room::all();
        $periods = Period::all();
        $devices = Device::all();

        return view('admin.room_bookings.index', compact('roomBookings', 'rooms', 'periods', 'devices'));
    }

    private function validateRoomBooking(Request $request)
    {
        return $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'room_address_id' => 'required|exists:room_addresses,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id|gte:start_period_id',
            'purpose' => 'required|string|max:255',
            'devices.*.quantity' => 'nullable|integer|min:1',
        ]);
    }

    public function create()
    {
        $rooms = Room::all();  // Lấy danh sách phòng học
        $devices = Device::all();  // Lấy danh sách thiết bị học
        return view('admin.room_bookings.create', compact('rooms', 'devices'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $this->validateRoomBooking($request);

        // Kiểm tra số lượng thiết bị
        $deviceQuantities = $request->input('device_quantity', []);
        $devices = $request->input('devices', []);

        foreach ($devices as $index => $deviceId) {
            $device = Device::find($deviceId);
            $quantity = $deviceQuantities[$index] ?? 0;

            // Kiểm tra số lượng thiết bị có đủ không
            if ($device && $device->quantity < $quantity) {
                return back()->withErrors([
                    'device_quantity' => "Số lượng thiết bị '{$device->device_name}' không đủ."
                ]);
            }
        }

        // Tạo phòng học và lưu thông tin thiết bị mượn
        $roomBooking = RoomBooking::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'start_period_id' => $request->start_period_id,
            'end_period_id' => $request->end_period_id,
            'purpose' => $request->purpose,
            'status' => $request->status,
        ]);

        // Lưu thông tin thiết bị mượn
        foreach ($devices as $index => $deviceId) {
            $deviceQuantity = $deviceQuantities[$index];

            // Gắn thiết bị với số lượng đã mượn
            $roomBooking->devices()->attach($deviceId, ['quantity' => $deviceQuantity]);

            // Cập nhật lại số lượng thiết bị trong bảng devices
            $device = Device::find($deviceId);
            $device->quantity -= $deviceQuantity;
            $device->save();
        }

        return redirect()->route('admin.room_bookings.index')->with('success', 'Đặt phòng thành công!');
    }

    public function update(Request $request, $id)
    {
        $this->validateRoomBooking($request);

        $roomBooking = RoomBooking::findOrFail($id);

        $roomBooking->update([
            'room_id' => $request->room_id,
            'room_address_id' => $request->room_address_id,
            'start_period_id' => $request->start_period_id,
            'end_period_id' => $request->end_period_id,
            'purpose' => $request->purpose,
        ]);

        return redirect()->route('admin.room_bookings.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $roomBooking = RoomBooking::findOrFail($id);
        $roomBooking->delete();

        return redirect()->route('admin.room_bookings.index')->with('success', 'Xóa thành công!');
    }

    public function updateStatus($id, $status)
    {
        $roomBooking = RoomBooking::findOrFail($id);
        $roomBooking->update(['status' => $status]);

        $roomBooking->room->update(['status' => $status === 'Đang sử dụng' ? 'Đang sử dụng' : 'Còn trống']);

        return redirect()->route('admin.room_bookings.index')->with('success', 'Trạng thái đã được cập nhật!');
    }
}
