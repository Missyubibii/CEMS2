<x-app-layout>
    <x-slot name="header">
        {{ __('Đặt phòng học - thiết bị học') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Đặt phòng học - thiết bị học</h2>

            <!-- Hiển thị thông báo thành công -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Hiển thị lỗi -->
            @if ($errors->any())
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('room_bookings.store') }}" method="POST">
                @csrf

                <!-- Địa chỉ phòng học -->
                <label for="room_id" class="block mb-2 font-medium">Chọn địa chỉ phòng học:</label>
                <select name="room_id" id="room_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->room_name }} - {{ $room->building->building_name }} -
                            {{ $room->campus->campus_name }}
                        </option>
                    @endforeach
                </select>
                @error('room_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <!-- Ngày đặt phòng -->
                <label for="booking_date" class="block mb-2 font-medium">Ngày đặt phòng:</label>
                <input type="date" name="booking_date" id="booking_date" required
                    class="w-full p-2.5 mb-4 border rounded" min="{{ date('Y-m-d') }}"
                    value="{{ old('booking_date') }}">
                @error('booking_date')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <!-- Tiết bắt đầu -->
                <label for="start_period_id" class="block mb-2 font-medium">Tiết bắt đầu:</label>
                <select name="start_period_id" id="start_period_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}"
                            {{ old('start_period_id') == $period->id ? 'selected' : '' }}>
                            {{ $period->name }}
                        </option>
                    @endforeach
                </select>
                @error('start_period_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <!-- Tiết kết thúc -->
                <label for="end_period_id" class="block mb-2 font-medium">Tiết kết thúc:</label>
                <select name="end_period_id" id="end_period_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}"
                            {{ old('end_period_id') == $period->id ? 'selected' : '' }}>
                            {{ $period->name }}
                        </option>
                    @endforeach
                </select>
                @error('end_period_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <!-- Mục đích -->
                <label for="purpose" class="block mb-2 font-medium">Mục đích:</label>
                <textarea name="purpose" id="purpose" required class="w-full p-2.5 mb-4 border rounded">{{ old('purpose') }}</textarea>
                @error('purpose')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <!-- Tùy chọn đặt thiết bị onchange="this.form.submit()-->
                <label class="block mb-2 font-medium">Bạn có muốn đặt thiết bị không?</label>
                <div class="flex items-center mb-4">
                    <input type="radio" name="book_device" id="book_device_yes" value="yes" class="mr-2"
                        {{-- {{ old('book_device', $bookDevice) === 'yes' ? 'checked' : '' }} onchange="this.form.submit()"> --}}
                        {{ old('book_device', $bookDevice) === 'yes' ? 'checked' : '' }}>
                    <label for="book_device_yes" class="mr-4">Có</label>

                    <input type="radio" name="book_device" id="book_device_no" value="no" class="mr-2"
                        {{-- {{ old('book_device', $bookDevice) === 'no' ? 'checked' : '' }} onchange="this.form.submit()"> --}}
                        {{ old('book_device', $bookDevice) === 'no' ? 'checked' : '' }}>
                    <label for="book_device_no">Không</label>
                </div>
                @error('book_device')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <!-- Hiển thị danh sách thiết bị nếu chọn "Có" -->
                @if (old('book_device', $bookDevice) === 'yes')
                    <label class="block mb-2 font-medium">Chọn thiết bị:</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($devices as $device)
                            <div class="flex items-center space-x-4 mb-2">
                                <input type="checkbox" name="devices[{{ $device->id }}]"
                                    id="device_{{ $device->id }}" value="{{ $device->id }}"
                                    {{ old('devices.' . $device->id) ? 'checked' : '' }}>
                                <label for="device_{{ $device->id }}" class="flex-1">
                                    {{ $device->device_name }} (Còn: {{ $device->quantity }})
                                </label>
                                <input type="number" name="device_quantity[{{ $device->id }}]" min="1"
                                    class="w-20 p-2.5 border rounded" placeholder="Số lượng"
                                    value="{{ old('device_quantity.' . $device->id) }}">
                            </div>
                        @endforeach
                    </div>
                    {{-- @error('devices')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    @error('device_quantity')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror --}}
                @endif

                <!-- Nút gửi -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Đặt phòng</button>
            </form>
        </div>
    </section>
</x-app-layout>
