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
                <select name="room_id" id="room_id" required class="w-full p-2.5 mb-4 border rounded" aria-label="Chọn phòng học">
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
                <select name="start_period_id" id="start_period_id" required class="w-full p-2.5 mb-4 border rounded" aria-label="Chọn tiết bắt đầu">
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
                <select name="end_period_id" id="end_period_id" required class="w-full p-2.5 mb-4 border rounded" aria-label="Chọn tiết kết thúc">
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
                        {{ old('book_device', $bookDevice) === 'yes' ? 'checked' : '' }}
                        onchange="document.getElementById('device-section').style.display = this.checked ? 'block' : 'none'">
                    <label for="book_device_yes" class="mr-4">Có</label>

                    <input type="radio" name="book_device" id="book_device_no" value="no" class="mr-2"
                        {{ old('book_device', $bookDevice) === 'no' ? 'checked' : '' }}
                        onchange="document.getElementById('device-section').style.display = 'none'">
                    <label for="book_device_no">Không</label>
                </div>
                @error('book_device')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <!-- Hiển thị danh sách thiết bị nếu chọn "Có" -->
                <div id="device-section" style="display: {{ old('book_device', $bookDevice) === 'yes' ? 'block' : 'none' }}">
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
                    @error('devices')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    @error('device_quantity')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nút gửi -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Đặt phòng</button>
            </form>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const deviceSection = document.getElementById('device-section');
            const bookDeviceYes = document.getElementById('book_device_yes');
            const bookDeviceNo = document.getElementById('book_device_no');
            const deviceInputs = document.querySelectorAll('input[type="number"]');
            const deviceCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="devices"]');

            // Show error message function
            function showError(message, element) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-red-500 mb-2 error-message';
                errorDiv.textContent = message;

                // Remove any existing error message
                const existingError = element.parentElement.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }

                element.parentElement.insertBefore(errorDiv, element.nextSibling);
                element.classList.add('border-red-500');
            }

            // Clear error message function
            function clearError(element) {
                const errorDiv = element.parentElement.querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.remove();
                }
                element.classList.remove('border-red-500');
            }

            // Handle device radio button changes
            bookDeviceYes.addEventListener('change', function() {
                deviceSection.style.display = 'block';
            });

            bookDeviceNo.addEventListener('change', function() {
                deviceSection.style.display = 'none';
                // Clear device selections
                deviceCheckboxes.forEach(checkbox => checkbox.checked = false);
                deviceInputs.forEach(input => input.value = '');
            });

            // Handle device quantity changes
            deviceInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const deviceId = this.name.match(/\d+/)[0];
                    const checkbox = document.getElementById('device_' + deviceId);
                    const maxQuantity = parseInt(checkbox.parentElement.querySelector('label').textContent.match(/Còn: (\d+)/)[1]);

                    clearError(this);

                    if (this.value > maxQuantity) {
                        this.value = maxQuantity;
                        showError('Số lượng không thể vượt quá ' + maxQuantity, this);
                    }

                    if (this.value > 0) {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                });
            });

            // Handle device checkbox changes
            deviceCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const quantityInput = this.parentElement.querySelector('input[type="number"]');
                    if (!this.checked) {
                        quantityInput.value = '';
                        clearError(quantityInput);
                    } else if (!quantityInput.value) {
                        quantityInput.value = '1';
                    }
                });
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                let hasError = false;

                // Clear all existing error messages
                form.querySelectorAll('.error-message').forEach(error => error.remove());
                form.querySelectorAll('.border-red-500').forEach(element => element.classList.remove('border-red-500'));

                // Validate room selection
                const room = document.getElementById('room_id');
                if (!room.value) {
                    e.preventDefault();
                    showError('Vui lòng chọn phòng học', room);
                    hasError = true;
                }

                // Validate booking date
                const bookingDate = document.getElementById('booking_date');
                if (!bookingDate.value) {
                    e.preventDefault();
                    showError('Vui lòng chọn ngày đặt phòng', bookingDate);
                    hasError = true;
                } else {
                    const selectedDate = new Date(bookingDate.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (selectedDate < today) {
                        e.preventDefault();
                        showError('Ngày đặt phòng không thể là ngày trong quá khứ', bookingDate);
                        hasError = true;
                    }
                }

                // Validate period selection
                const startPeriod = document.getElementById('start_period_id');
                const endPeriod = document.getElementById('end_period_id');

                if (!startPeriod.value) {
                    e.preventDefault();
                    showError('Vui lòng chọn tiết bắt đầu', startPeriod);
                    hasError = true;
                }

                if (!endPeriod.value) {
                    e.preventDefault();
                    showError('Vui lòng chọn tiết kết thúc', endPeriod);
                    hasError = true;
                }

                if (parseInt(endPeriod.value) < parseInt(startPeriod.value)) {
                    e.preventDefault();
                    showError('Tiết kết thúc phải lớn hơn hoặc bằng tiết bắt đầu', endPeriod);
                    hasError = true;
                }

                // Validate purpose
                const purpose = document.getElementById('purpose');
                if (!purpose.value.trim()) {
                    e.preventDefault();
                    showError('Vui lòng nhập mục đích', purpose);
                    hasError = true;
                }

                // Validate device selections if "Yes" is selected
                if (bookDeviceYes.checked) {
                    let hasCheckedDevice = false;
                    let hasInvalidQuantity = false;

                    deviceCheckboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            hasCheckedDevice = true;
                            const quantityInput = checkbox.parentElement.querySelector('input[type="number"]');
                            if (!quantityInput.value || parseInt(quantityInput.value) < 1) {
                                hasInvalidQuantity = true;
                                showError('Vui lòng nhập số lượng', quantityInput);
                            }
                        }
                    });

                    if (!hasCheckedDevice) {
                        e.preventDefault();
                        const deviceSectionLabel = deviceSection.querySelector('label');
                        showError('Vui lòng chọn ít nhất một thiết bị', deviceSectionLabel);
                        hasError = true;
                    }

                    if (hasInvalidQuantity) {
                        e.preventDefault();
                        hasError = true;
                    }
                }

                if (hasError) {
                    // Scroll to the first error message
                    const firstError = form.querySelector('.error-message');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    </script>
</x-app-layout>
