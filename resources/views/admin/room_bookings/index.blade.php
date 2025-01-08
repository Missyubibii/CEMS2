<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý đơn đặt phòng') }}
    </x-slot>

    <div class="p-4 sm:ml-64 sm:p-5">
        <div class="overflow-x-auto rounded-lg">
            <div class="inline-block min-w-full align-middle">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <table class="table-auto w-full mt-4 divide-y divide-gray-200 dark:divide-gray-600">
                        <thead>
                            <tr>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Lịch đặt
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Tên người đặt
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Tên phòng - Tòa học - Cơ sở
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Thời gian đặt
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Trạng thái đơn
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($roomBookings as $roomBooking)
                                <tr>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->booking_date }}
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->user->name }}
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->room->room_name }} -
                                        {{ $roomBooking->room->building->building_name }} -
                                        {{ $roomBooking->room->campus->campus_name }}
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->startPeriod->name }} - {{ $roomBooking->endPeriod->name }}
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->status }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        @if ($roomBooking->status === 'Chờ duyệt')
                                            <span
                                                class="bg-gray-400 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $roomBooking->status }}
                                            </span>
                                        @elseif ($roomBooking->status === 'Từ chối duyệt')
                                            <span
                                                class="bg-red-400 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $roomBooking->status }}
                                            </span>
                                        @elseif ($roomBooking->status === 'Đang sử dụng')
                                            <span
                                                class="bg-green-400 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $roomBooking->status }}
                                            </span>
                                        @elseif ($roomBooking->status === 'Đã trả phòng')
                                            <span
                                                class="bg-yellow-400 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $roomBooking->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        @if ($roomBooking->status === 'Chờ duyệt')
                                            <form method="POST"
                                                action="{{ route('admin.room_bookings.approve', $roomBooking) }}"
                                                class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300">
                                                    Duyệt
                                                </button>
                                            </form>

                                            <form method="POST"
                                                action="{{ route('admin.room_bookings.reject', $roomBooking) }}"
                                                class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300">
                                                    Từ chối
                                                </button>
                                            </form>
                                        @elseif ($roomBooking->status === 'Đang sử dụng')
                                            <form method="POST"
                                                action="{{ route('admin.room_bookings.returnRoom', $roomBooking) }}"
                                                class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                                                    Trả phòng
                                                </button>
                                            </form>
                                        @endif
                                        <button
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300"
                                            data-modal-toggle="viewModal-{{ $roomBooking->id }}">
                                            Xem đơn
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal View Booking -->
                                <div id="viewModal-{{ $roomBooking->id }}" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                            <!-- Modal Header -->
                                            <div
                                                class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Thông tin chi tiết đơn đặt phòng
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-toggle="viewModal-{{ $roomBooking->id }}">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Đóng cửa sổ</span>
                                                </button>
                                            </div>
                                            <p class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                Ngày tạo đơn:
                                                {{ $roomBooking->created_at->format('d/m/Y') }}
                                            </p>
                                            <!-- Modal Body -->
                                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                                <div class="sm:col-span-2" rows="5">
                                                    <p
                                                        class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                        Người đặt:
                                                        <a
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                            {{ $roomBooking->user->name }}
                                                        </a>
                                                    </p>
                                                </div>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Địa chỉ phòng học
                                                    <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">Phòng
                                                        {{ $roomBooking->room->room_name }} - Tòa
                                                        {{ $roomBooking->room->building->building_name }} -
                                                        {{ $roomBooking->room->campus->campus_name }}
                                                    </a>
                                                </p>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Tiết học:
                                                    <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                        {{ $roomBooking->startPeriod->name }} -
                                                        {{ $roomBooking->endPeriod->name }}
                                                    </a>
                                                </p>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Ngày đặt phòng:
                                                    <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                        {{ $roomBooking->booking_date }}
                                                    </a>
                                                </p>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Trạng thái:
                                                    <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                        {{ $roomBooking->status }}</a>
                                                </p>
                                                <div class="sm:col-span-2" rows="5">
                                                    <p class="block mb-2 text-sm font-medium text-gray-900 ">
                                                        Mục đích:
                                                        <a
                                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                                            {{ $roomBooking->purpose }}
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="flex justify-end mt-4 space-x-2">
                                                <a href="{{ route('admin.room_bookings.edit', $roomBooking) }}"
                                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Sửa</a>
                                                <form method="POST"
                                                    action="{{ route('admin.room_bookings.destroy', $roomBooking) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800">Xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
