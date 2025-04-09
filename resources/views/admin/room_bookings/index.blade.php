<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý đơn đặt phòng') }}
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Danh sách đơn đặt phòng</h2>

            <!-- Bảng danh sách -->
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Lịch đặt</th>
                            <th scope="col" class="px-6 py-3">Tên người đặt</th>
                            <th scope="col" class="px-6 py-3">Tên phòng - Tòa học - Cơ sở</th>
                            <th scope="col" class="px-6 py-3">Thời gian đặt</th>
                            <th scope="col" class="px-6 py-3">Trạng thái đơn</th>
                            <th scope="col" class="px-6 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roomBookings as $roomBooking)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($roomBooking->booking_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $roomBooking->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $roomBooking->room->room_name }} -
                                    {{ $roomBooking->room->building->building_name }} -
                                    {{ $roomBooking->room->campus->campus_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $roomBooking->startPeriod->name }} - {{ $roomBooking->endPeriod->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($roomBooking->status === 'Chờ duyệt')
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $roomBooking->status }}
                                        </span>
                                    @elseif ($roomBooking->status === 'Từ chối duyệt')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $roomBooking->status }}
                                        </span>
                                    @elseif ($roomBooking->status === 'Đang sử dụng')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $roomBooking->status }}
                                        </span>
                                    @elseif ($roomBooking->status === 'Đã trả phòng')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $roomBooking->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        @if ($roomBooking->status === 'Chờ duyệt')
                                            <form method="POST" action="{{ route('admin.room_bookings.approve', $roomBooking) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-green-600 inline-flex items-center hover:text-white border border-green-600 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                    Duyệt
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.room_bookings.reject', $roomBooking) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                    Từ chối
                                                </button>
                                            </form>
                                        @elseif ($roomBooking->status === 'Đang sử dụng')
                                            <form method="POST" action="{{ route('admin.room_bookings.returnRoom', $roomBooking) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-blue-600 inline-flex items-center hover:text-white border border-blue-600 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                    Trả phòng
                                                </button>
                                            </form>
                                        @endif

                                        <button class="text-blue-600 inline-flex items-center hover:text-white border border-blue-600 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center"
                                            data-modal-toggle="viewModal-{{ $roomBooking->id }}">
                                            Chi tiết
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal chi tiết -->
                            <div id="viewModal-{{ $roomBooking->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Chi tiết đơn đặt phòng
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-toggle="viewModal-{{ $roomBooking->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5 space-y-4">
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                <strong>Ngày tạo đơn:</strong> {{ \Carbon\Carbon::parse($roomBooking->created_at)->format('d/m/Y') }}
                                            </p>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div class="col-span-2">
                                                    <p><strong>Người đặt:</strong> {{ $roomBooking->user->name }}</p>
                                                </div>
                                                <div class="col-span-2">
                                                    <p><strong>Địa chỉ phòng:</strong> Phòng {{ $roomBooking->room->room_name }} -
                                                    Tòa {{ $roomBooking->room->building->building_name }} -
                                                    {{ $roomBooking->room->campus->campus_name }}</p>
                                                </div>
                                                <div>
                                                    <p><strong>Tiết học:</strong> {{ $roomBooking->startPeriod->name }} -
                                                    {{ $roomBooking->endPeriod->name }}</p>
                                                </div>
                                                <div>
                                                    <p><strong>Trạng thái:</strong> {{ $roomBooking->status }}</p>
                                                </div>
                                                <div class="col-span-2">
                                                    <p><strong>Mục đích:</strong> {{ $roomBooking->purpose }}</p>
                                                </div>
                                                <div class="col-span-2">
                                                    <p><strong>Thiết bị học:</strong></p>
                                                    <div class="grid grid-cols-2 gap-4 mt-2">
                                                        @foreach ($roomBooking->devices as $device)
                                                            <div class="p-3 bg-gray-50 rounded">
                                                                Tên: {{ $device->device_name }}<br>
                                                                Loại: {{ $device->category }}<br>
                                                                Số lượng: {{ $device->pivot->quantity }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                                            <form method="POST" action="{{ route('admin.room_bookings.destroy', $roomBooking) }}" class="mr-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    Xóa
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.room_bookings.edit', $roomBooking) }}"
                                                class="text-blue-600 inline-flex items-center hover:text-white border border-blue-600 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Sửa
                                            </a>
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
                            Hiển thị {{ $roomBookings->firstItem() ?? 0 }}-{{ $roomBookings->lastItem() ?? 0 }}
                            trong tổng số {{ $roomBookings->total() ?? 0 }} đơn
                        </div>

                        <!-- Links phân trang -->
                        <div>
                            {{ $roomBookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
