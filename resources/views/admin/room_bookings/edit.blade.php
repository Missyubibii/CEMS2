<x-app-layout>
    <x-slot name="header">
        {{ __('Sửa đơn đặt phòng') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Sửa đơn đặt phòng</h2>
            <form method="POST" action="{{ route('admin.room_bookings.update', $roomBooking->id) }}">
                @csrf
                @method('PUT')

                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tài khoản
                        </label>
                        <select id="user_id" name="user_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Chọn tài khoản</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $roomBooking->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="room_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Phòng học
                        </label>
                        <select id="room_id" name="room_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Chọn phòng học</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ $room->id == $roomBooking->room_id ? 'selected' : '' }}>
                                    {{ $room->room_name }} - {{ $room->building->building_name ?? 'No Building' }} - {{ $room->campus->campus_name ?? 'No Campus' }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_period_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tiết bắt đầu
                        </label>
                        <select id="start_period_id" name="start_period_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Chọn tiết</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ $period->id == $roomBooking->start_period_id ? 'selected' : '' }}>
                                    {{ $period->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('start_period_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_period_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tiết kết thúc
                        </label>
                        <select id="end_period_id" name="end_period_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Chọn tiết</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ $period->id == $roomBooking->end_period_id ? 'selected' : '' }}>
                                    {{ $period->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('end_period_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="booking_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Ngày đặt
                        </label>
                        <input type="date" id="booking_date" name="booking_date" required
                            value="{{ old('booking_date', $roomBooking->booking_date) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @error('booking_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="purpose" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Mục đích
                        </label>
                        <textarea id="purpose" name="purpose" rows="5" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Nhập mục đích đặt phòng...">{{ old('purpose', $roomBooking->purpose) }}</textarea>
                        @error('purpose')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit"
                        class="text-blue-600 inline-flex items-center hover:text-white border border-blue-600 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="w-5 h-5 mr-1 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 11.917 9.724 16.5 19 7.5" />
                        </svg>
                        Lưu thông tin
                    </button>

                    <a href="{{ route('admin.room_bookings.index') }}"
                        class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
