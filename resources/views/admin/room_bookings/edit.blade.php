<x-app-layout>
    <x-slot name="header">
        {{ __('Sửa đơn đặt phòng') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Sửa đơn đặt phòng</h2>

            <!-- Form sửa đơn đặt phòng -->
            <form method="POST" action="{{ route('admin.room_bookings.update', $roomBooking->id) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Tài khoản</label>
                        <select id="user_id" name="user_id" class="w-full mt-1 border-gray-300 rounded-md">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $roomBooking->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700">Phòng học</label>
                        <select id="room_id" name="room_id" class="w-full mt-1 border-gray-300 rounded-md">
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ $room->id == $roomBooking->room_id ? 'selected' : '' }}>{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="room_address_id" class="block text-sm font-medium text-gray-700">Địa chỉ phòng</label>
                        <select id="room_address_id" name="room_address_id" class="w-full mt-1 border-gray-300 rounded-md">
                            @foreach($roomAddresses as $roomAddress)
                                <option value="{{ $roomAddress->id }}" {{ $roomAddress->id == $roomBooking->room_address_id ? 'selected' : '' }}>
                                    {{ $roomAddress->building->name }} - {{ $roomAddress->campus->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="time_slot" class="block text-sm font-medium text-gray-700">Chọn thời gian tiết học</label>
                        <input type="text" id="time_slot" name="time_slot" class="w-full mt-1 border-gray-300 rounded-md" value="{{ $roomBooking->time_slot }}" required placeholder="Ví dụ: Tiết 1, Tiết 2">
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md">Cập nhật đơn đặt phòng</button>
            </form>
        </div>
    </section>
</x-app-layout>