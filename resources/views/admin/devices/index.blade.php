<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý thiết bị học') }}
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Danh sách thiết bị học</h2>

            <!-- Nút thêm mới -->
            <div class="flex justify-end mb-4">
                <button id="add_devices_button" data-modal-target="add_devices" data-modal-toggle="add_devices"
                    type="button" onclick="toggleAddForm()"
                    class="inline-flex items-center text-blue-600 hover:text-white border border-blue-600 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="w-5 h-5 mr-1 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Thêm thiết bị học
                </button>
            </div>

            <!-- Bảng danh sách -->
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Tên thiết bị</th>
                            <th scope="col" class="px-6 py-3">Loại thiết bị</th>
                            <th scope="col" class="px-6 py-3">Số lượng</th>
                            <th scope="col" class="px-6 py-3">Tình trạng</th>
                            <th scope="col" class="px-6 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $device)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">{{ $device->id }}</td>
                                <td class="px-6 py-4">{{ $device->device_name }}</td>
                                <td class="px-6 py-4">{{ $device->category }}</td>
                                <td class="px-6 py-4 font-semibold">{{ $device->quantity }}</td>
                                <td class="px-6 py-4">
                                    @if ($device->status === 'Đang sử dụng')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $device->status }}
                                        </span>
                                    @elseif ($device->status === 'Chưa sử dụng')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $device->status }}
                                        </span>
                                    @elseif ($device->status === 'Đang bảo trì')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $device->status }}
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $device->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.devices.edit', $device) }}"
                                            class="text-blue-600 inline-flex items-center hover:text-white border border-blue-600 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                            <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                            Sửa
                                        </a>
                                        <button data-modal-target="deleteModal-{{ $device->id }}"
                                            data-modal-toggle="deleteModal-{{ $device->id }}"
                                            class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                            <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                            </svg>
                                            Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal xóa -->
                            <div id="deleteModal-{{ $device->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="p-4 md:p-5 text-center">
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                Bạn có chắc chắn muốn xóa thiết bị này?
                                            </h3>
                                            <form action="{{ route('admin.devices.destroy', $device) }}" method="POST" class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Xóa
                                                </button>
                                                <button type="button"
                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                                                    data-modal-hide="deleteModal-{{ $device->id }}">
                                                    Hủy
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="mt-4">
                    <div class="flex items-center justify-between">
                        <!-- Hiển thị thông tin về số trang -->
                        <div class="text-sm text-gray-500">
                            Hiển thị {{ $devices->firstItem() ?? 0 }}-{{ $devices->lastItem() ?? 0 }}
                            trong tổng số {{ $devices->total() ?? 0 }} thiết bị
                        </div>

                        <!-- Links phân trang -->
                        <div>
                            {{ $devices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form thêm mới -->
    <form id="add_devices" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Thêm thiết bị mới
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="add_devices">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form method="POST" action="{{ route('admin.devices.store') }}">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="device_name" class="block mb-2 text-sm font-medium text-gray-900">
                                    Tên thiết bị
                                </label>
                                <input type="text" id="device_name" name="device_name" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                    placeholder="Nhập tên thiết bị">
                            </div>
                            <div class="col-span-2">
                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900">
                                    Loại thiết bị
                                </label>
                                <input type="text" id="category" name="category" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                    placeholder="Nhập loại thiết bị">
                            </div>
                            <div>
                                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">
                                    Số lượng
                                </label>
                                <input type="number" id="quantity" name="quantity" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                    placeholder="Nhập số lượng">
                            </div>
                            <div>
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
                                    Trạng thái
                                </label>
                                <select id="status" name="status" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="Chưa sử dụng">Chưa sử dụng</option>
                                    <option value="Đang sử dụng">Đang sử dụng</option>
                                    <option value="Đang bảo trì">Đang bảo trì</option>
                                    <option value="Hỏng hóc">Hỏng hóc</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Thêm thiết bị
                            </button>
                            <button type="button"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900"
                                data-modal-hide="add_devices">
                                Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
