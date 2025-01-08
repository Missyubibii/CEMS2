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
    // Hiển thị danh sách đơn đặt phòng
    public function index()
    {
        $roomBookings = RoomBooking::with(['user', 'room', 'startPeriod', 'endPeriod'])->get();
        return view('admin.room_bookings.index', compact('roomBookings'));
    }

    public function create(Request $request)
    {
        $rooms = Room::all();
        $periods = Period::all();
        $devices = Device::where('quantity', '>', 0)->get();
        $bookDevice = $request->input('book_device', 'no');

        if ($rooms->isEmpty() || $periods->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Không có dữ liệu phòng học hoặc tiết học khả dụng.']);
        }

        return view('room_bookings.store', compact('rooms', 'periods', 'devices', 'bookDevice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_period_id' => 'required|exists:periods,id',
            'end_period_id' => 'required|exists:periods,id',
            'purpose' => 'required|string|max:255',
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devices,id',
            'device_quantity' => 'nullable|array',
            'device_quantity.*' => 'integer|min:1',
        ]);

        if ($validated['start_period_id'] > $validated['end_period_id']) {
            return redirect()->back()->withErrors(['error' => 'Tiết bắt đầu không thể lớn hơn tiết kết thúc.']);
        }

        $booking = RoomBooking::create([
            'room_id' => $validated['room_id'],
            'start_period_id' => $validated['start_period_id'],
            'end_period_id' => $validated['end_period_id'],
            'purpose' => $validated['purpose'],
        ]);

        if (!empty($validated['devices'])) {
            foreach ($validated['devices'] as $deviceId) {
                $quantity = $validated['device_quantity'][$deviceId] ?? 0;
                $device = Device::find($deviceId);

                if (!$device || $device->quantity < $quantity) {
                    return redirect()->back()->withErrors([
                        'devices' => "Thiết bị {$device->device_name} không đủ số lượng khả dụng."
                    ]);
                }

                $booking->devices()->attach($deviceId, ['quantity' => $quantity]);
                $device->decrement('quantity', $quantity);
            }
        }

        return redirect()->route('room_bookings.timetable')->with('success', 'Đặt phòng thành công!');
    }


    // Hiển thị bảng lịch sử đặt phòng
    public function timetable()
    {
        $roomBookings = RoomBooking::with(['user', 'room', 'startPeriod', 'endPeriod'])->get();
        return view('room_bookings.timetable', compact('roomBookings'));
    }

    // Hiển thị trang duyệt đơn của admin
    public function adminApproval()
    {
        $pendingBookings = RoomBooking::with(['room', 'user', 'devices'])
            ->where('status', 'Chờ duyệt')
            ->get();

        return view('room_bookings.admin_approval', compact('pendingBookings'));
    }

    // Cập nhật trạng thái đơn đặt phòng bởi admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Chờ duyệt,Từ chối duyệt,Đang sử dụng,Đã trả phòng',
        ]);

        $booking = RoomBooking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return redirect()->route('admin.room_bookings.approval')
            ->with('success', 'Cập nhật trạng thái đơn đặt phòng thành công.');
    }

    // Cập nhật thông tin đơn đặt phòng
    public function update(Request $request, RoomBooking $roomBooking)
    {
        $request->validate([
            'user_id' => 'required',
            'room_id' => 'required',
            'start_period_id' => 'required',
            'end_period_id' => 'required',
            'booking_date' => 'required|date',
            'status' => 'required',
            'purpose' => 'required',
        ]);

        $roomBooking->update($request->all());
        return redirect()->route('admin.room_bookings.index')->with('success', 'Cập nhật đơn đặt phòng thành công!');
    }

    // Xóa đơn đặt phòng
    public function destroy(RoomBooking $roomBooking)
    {
        $roomBooking->delete();
        return redirect()->route('admin.room_bookings.index')->with('success', 'Đơn đặt phòng đã được xóa!');
    }
}
