<x-app-layout>
    <x-slot name="header">
        {{ __('Đặt phòng học - thiết bị học') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Đặt phòng học - thiết bị học</h2>

            <form action="{{ route('admin.room_bookings.store') }}" method="POST">
                @csrf

                <!-- Phòng học -->
                <label for="room_id">Chọn phòng học:</label>
                <select name="room_id" id="room_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>

                <!-- Thời gian bắt đầu -->
                <label for="start_period_id">Bắt đầu:</label>
                <select name="start_period_id" id="start_period_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                    @endforeach
                </select>

                <!-- Thời gian kết thúc -->
                <label for="end_period_id">Kết thúc:</label>
                <select name="end_period_id" id="end_period_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                    @endforeach
                </select>

                <!-- Mục đích -->
                <label for="purpose">Mục đích:</label>
                <textarea name="purpose" id="purpose" class="w-full p-2.5 mb-4 border rounded" required></textarea>

                <!-- Thiết bị -->
                <label>Chọn thiết bị:</label>
                @foreach ($devices as $device)
                    <div class="mb-2">
                        <input type="checkbox" name="devices[{{ $device->id }}]" id="device_{{ $device->id }}"
                            value="{{ $device->id }}">
                        <label for="device_{{ $device->id }}">{{ $device->device_name }} (Còn: {{ $device->quantity }})</label>
                        <input type="number" name="device_quantity[{{ $device->id }}]" min="1"
                            class="w-full p-2.5 border rounded mt-1" placeholder="Số lượng" />
                    </div>
                @endforeach

                <!-- Nút gửi -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Đặt phòng</button>
            </form>
        </div>
    </section>
</x-app-layout>
