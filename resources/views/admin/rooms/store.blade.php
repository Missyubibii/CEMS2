<x-app-layout>
    <x-slot name="header">
        {{ __('Thêm phòng học') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Thêm phòng học</h2>
            <form method="POST" action="{{ route('admin.rooms.store') }}">
                @csrf
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="room_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tên phòng học
                        </label>
                        <input type="text" id="room_name" name="room_name"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
                            focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white
                            dark:focus:ring-blue-500 dark:focus:border-blue-500
                            {{ $errors->has('room_name') ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600' }}"
                            placeholder="Nhập tên phòng học" value="{{ old('room_name') }}">
                        @error('room_name')
                            <div class="mt-2 text-sm text-red-600 dark:text-red-500 flex items-center">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label for="building_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tòa nhà
                        </label>
                        <select id="building_id" name="building_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Chọn tòa nhà</option>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}">{{ $building->building_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="campus_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cơ sở
                        </label>
                        <select id="campus_id" name="campus_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5">
                            <option value="">Chọn cơ sở</option>
                            @foreach ($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->campus_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="capacity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Sức chứa
                        </label>
                        <input type="number" id="capacity" name="capacity" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                            placeholder="Nhập số lượng phòng học">
                    </div>

                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Trạng thái
                        </label>
                        <select id="status" name="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5">
                            <option value="Còn trống">Còn trống</option>
                            <option value="Đang sử dụng">Đang sử dụng</option>
                            <option value="Đang bảo trì">Đang bảo trì</option>
                        </select>
                    </div>
                </div>
                <div class="space-x-2 whitespace-nowrap">
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Thêm phòng học
                    </button>
                    <a href="{{ route('admin.rooms.index') }}"
                        class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
