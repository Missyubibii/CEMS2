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
                <label for="room_address_id" class="block mb-2 font-medium">Chọn địa chỉ phòng học:</label>
                <select name="room_address_id" id="room_address_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->room_name }} - {{ $room->building->building_name }} - {{ $room->campus->campus_name }}
                        </option>
                    @endforeach
                </select>

                <!-- Ngày đặt phòng -->
                <label for="booking_date" class="block mb-2 font-medium">Ngày đặt phòng:</label>
                <input type="date" name="booking_date" id="booking_date" required
                    class="w-full p-2.5 mb-4 border rounded" min="{{ date('Y-m-d') }}">

                <!-- Tiết bắt đầu -->
                <label for="start_period_id" class="block mb-2 font-medium">Tiết bắt đầu:</label>
                <select name="start_period_id" id="start_period_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                    @endforeach
                </select>

                <!-- Tiết kết thúc -->
                <label for="end_period_id" class="block mb-2 font-medium">Tiết kết thúc:</label>
                <select name="end_period_id" id="end_period_id" required class="w-full p-2.5 mb-4 border rounded">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                    @endforeach
                </select>

                <!-- Mục đích -->
                <label for="purpose" class="block mb-2 font-medium">Mục đích:</label>
                <textarea name="purpose" id="purpose" required class="w-full p-2.5 mb-4 border rounded"></textarea>

                <!-- Tùy chọn đặt thiết bị -->
                <label class="block mb-2 font-medium">Bạn có muốn đặt thiết bị không?</label>
                <div class="flex items-center mb-4">
                    <input type="radio" name="book_device" id="book_device_yes" value="yes" class="mr-2"
                        {{ $bookDevice === 'yes' ? 'checked' : '' }} onchange="this.form.submit()">
                    <label for="book_device_yes" class="mr-4">Có</label>

                    <input type="radio" name="book_device" id="book_device_no" value="no" class="mr-2"
                        {{ $bookDevice === 'no' ? 'checked' : '' }} onchange="this.form.submit()">
                    <label for="book_device_no">Không</label>
                </div>

                <!-- Hiển thị danh sách thiết bị nếu chọn "Có" -->
                @if ($bookDevice === 'yes')
                    <label class="block mb-2 font-medium">Chọn thiết bị:</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($devices as $device)
                            <div class="flex items-center space-x-4 mb-2">
                                <input type="checkbox" name="devices[{{ $device->id }}]"
                                    id="device_{{ $device->id }}" value="{{ $device->id }}">
                                <label for="device_{{ $device->id }}" class="flex-1">
                                    {{ $device->device_name }} (Còn: {{ $device->quantity }})
                                </label>
                                <input type="number" name="device_quantity[{{ $device->id }}]" min="1"
                                    class="w-20 p-2.5 border rounded" placeholder="Số lượng">
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Nút gửi -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Đặt phòng</button>
            </form>
        </div>
    </section>
</x-app-layout>
