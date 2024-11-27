<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý đơn đặt phòng') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Danh sách đơn đặt phòng</h2>

            <!-- Form thêm đơn đặt phòng -->
            <form method="POST" action="{{ route('admin.room_bookings.store') }}" class="mb-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Tài khoản</label>
                        <select id="user_id" name="user_id" class="w-full mt-1 border-gray-300 rounded-md">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700">Phòng học</label>
                        <select id="room_id" name="room_id" class="w-full mt-1 border-gray-300 rounded-md">
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="room_address_id" class="block text-sm font-medium text-gray-700">Địa chỉ phòng</label>
                        <select id="room_address_id" name="room_address_id" class="w-full mt-1 border-gray-300 rounded-md">
                            @foreach($roomAddresses as $roomAddress)
                                <option value="{{ $roomAddress->id }}">{{ $roomAddress->building->name }} - {{ $roomAddress->campus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="time_slot" class="block text-sm font-medium text-gray-700">Chọn thời gian tiết học</label>
                        <input type="text" id="time_slot" name="time_slot" class="w-full mt-1 border-gray-300 rounded-md" required placeholder="Ví dụ: Tiết 1, Tiết 2">
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md">Tạo đơn đặt phòng</button>
            </form>

            <!-- Bảng danh sách đơn đặt phòng -->
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Tài khoản</th>
                        <th class="px-4 py-2 text-left">Tên phòng</th>
                        <th class="px-4 py-2 text-left">Địa chỉ phòng</th>
                        <th class="px-4 py-2 text-left">Thời gian đặt</th>
                        <th class="px-4 py-2 text-left">Trạng thái</th>
                        <th class="px-4 py-2 text-left">Thời gian làm đơn</th>
                        <th class="px-4 py-2 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomBookings as $roomBooking)
                        <tr>
                            <td class="px-4 py-2">{{ $roomBooking->user->name }}</td>
                            <td class="px-4 py-2">{{ $roomBooking->room->room_name }}</td>
                            <td class="px-4 py-2">{{ $roomBooking->roomAddress->building->name }} - {{ $roomBooking->roomAddress->campus->name }}</td>
                            <td class="px-4 py-2">{{ $roomBooking->time_slot }}</td>
                            <td class="px-4 py-2">{{ $roomBooking->status }}</td>
                            <td class="px-4 py-2">{{ $roomBooking->created_at }}</td>
                            <td class="px-4 py-2">
                                <!-- Sửa -->
                                <a href="{{ route('admin.room_bookings.edit', $roomBooking->id) }}" class="text-yellow-500">Sửa</a>
                                <!-- Xóa -->
                                <form action="{{ route('admin.room_bookings.destroy', $roomBooking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Xóa</button>
                                </form>
                                <!-- Cập nhật trạng thái -->
                                @if($roomBooking->status == 'Chờ duyệt')
                                    <a href="{{ route('admin.room_bookings.updateStatus', ['id' => $roomBooking->id, 'status' => 'Đang mượn phòng']) }}" class="text-green-500">Duyệt</a>
                                @elseif($roomBooking->status == 'Đang mượn phòng')
                                    <a href="{{ route('admin.room_bookings.updateStatus', ['id' => $roomBooking->id, 'status' => 'Chưa trả phòng']) }}" class="text-yellow-500">Chưa trả phòng</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="mt-4">
                {{ $roomBookings->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
