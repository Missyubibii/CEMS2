<x-app-layout>
    <x-slot name="header">
        {{ __('Đặt phòng học - thiết bị học') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Đặt phòng học - thiết bị học</h2>
            <form method="POST" action="{{ route('room_bookings.store') }}">
                @csrf
                <!-- Chọn phòng học -->
                <label for="room_id" class="block text-sm font-medium">Chọn phòng học</label>
                <select id="room_id" name="room_id" class="block w-full">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                    @endforeach
                </select>

                <!-- Chọn thiết bị -->
                <label for="device_id" class="block text-sm font-medium">Chọn thiết bị</label>
                <select id="device_id" name="devices[]" multiple class="block w-full">
                    @foreach ($devices as $device)
                        <option value="{{ $device->id }}" data-quantity="{{ $device->quantity }}">
                            {{ $device->device_name }} (Còn {{ $device->quantity }} cái)
                        </option>
                    @endforeach
                </select>

                <!-- Số lượng thiết bị -->
                <div id="device_quantity_container">
                    @foreach ($devices as $device)
                        <div>
                            <label for="device_quantity_{{ $device->id }}"
                                class="block text-sm font-medium">{{ $device->device_name }} Số lượng</label>
                            <input type="number" name="device_quantity[]" min="1" max="{{ $device->quantity }}"
                                class="block w-full" id="device_quantity_{{ $device->id }}" value="1">
                        </div>
                    @endforeach
                </div>

                <!-- Các trường khác -->
                <button type="submit" class="btn btn-primary">Đặt phòng</button>
            </form>
        </div>
    </section>
</x-app-layout>
