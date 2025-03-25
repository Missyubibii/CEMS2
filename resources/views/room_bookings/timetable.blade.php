<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý đơn đặt phòng') }}
    </x-slot>

    <div class="p-4 sm:ml-64 sm:p-5">
        <div class="overflow-x-auto rounded-lg">
            <div class="flex flex-col md:flex-row items-center justify-end space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <a href="{{ route('room_bookings.create') }}" id="add_room_bookings_button" type="button"
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="w-3.5 h-3.5 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        Đặt phòng - thiết bị
                    </a>
                </div>
            </div>
            <div class="inline-block min-w-full align-middle">
                <div class="bg-white overflow-x-auto shadow sm:rounded-lg">
                    <table class="table-auto w-full mt-4 divide-y divide-gray-200 dark:divide-gray-600">
                        <thead>
                            <tr>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Ngày đặt phòng</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Tài khoản đặt</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Phòng - Tòa - Cơ sở</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Thời gian đặt</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Trạng thái đơn</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Thiết bị</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomBookings as $roomBooking)
                                <tr>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ \Carbon\Carbon::parse($roomBooking->booking_date)->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->user->name }}</td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->room->room_name }} -
                                        {{ $roomBooking->room->building->building_name }} -
                                        {{ $roomBooking->room->campus->campus_name }}
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $roomBooking->startPeriod->name }} - {{ $roomBooking->endPeriod->name }}</td>
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
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        @foreach ($roomBooking->devices as $device)
                                            {{ $device->device_name }} ({{ $device->device_type }}) - Số lượng:
                                            {{ $device->pivot->quantity }}<br>
                                        @endforeach
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <button
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300"
                                            data-modal-toggle="viewModal-{{ $roomBooking->id }}">
                                            Chi tiết
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
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"> Thông
                                                    tin chi tiết đơn đặt phòng </h3>
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
                                                {{ \Carbon\Carbon::parse($roomBooking->created_at)->format('d/m/Y') }}
                                            </p>
                                            <!-- Modal Body -->
                                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                                <div class="sm:col-span-2" rows="5">
                                                    <p
                                                        class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                        Người đặt: <a
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                            {{ $roomBooking->user->name }} </a>
                                                    </p>
                                                </div>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Địa chỉ phòng học: <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                        Phòng {{ $roomBooking->room->room_name }} - Tòa
                                                        {{ $roomBooking->room->building->building_name }} -
                                                        {{ $roomBooking->room->campus->campus_name }} </a>
                                                </p>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Trạng thái phòng: <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                        {{ $roomBooking->room->status }} </a>
                                                </p>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Tiết học: <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                        {{ $roomBooking->startPeriod->name }} -
                                                        {{ $roomBooking->endPeriod->name }} </a>
                                                </p>
                                                <p
                                                    class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                    Ngày đặt phòng: <a
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                                        {{ \Carbon\Carbon::parse($roomBooking->booking_date)->format('d/m/Y') }}
                                                    </a>
                                                </p>
                                                <div class="sm:col-span-2" rows="5">
                                                    <p class="block mb-2 text-sm font-medium text-gray-900 "> Mục đích:
                                                        <a
                                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                                            {{ $roomBooking->purpose }} </a>
                                                    </p>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <p
                                                        class="block mb-2 text-base font-medium text-gray-900 dark:text-white">
                                                        Thiết bị học:
                                                    </p>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        @foreach ($roomBooking->devices as $device)
                                                            <div class="flex items-center space-x-4 mb-2">
                                                                <p class="flex-1">
                                                                    Tên thiết bị: {{ $device->device_name }} <br>
                                                                    Loại thiết bị: {{ $device->device_type }} <br>
                                                                    Số lượng: {{ $device->pivot->quantity }}
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-end space-x-4">
                                                <form method="POST"
                                                    action="{{ route('room_bookings.destroy', $roomBooking->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800 focus:ring-4 font-medium rounded-lg text-sm px-4 py-2 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-red-800">
                                                        Xóa
                                                    </button>
                                                </form>
                                                <a href="{{ route('room_bookings.edit', $roomBooking->id) }}"
                                                    class="text-blue-600 hover:text-blue-800 focus:ring-4 font-medium rounded-lg text-sm px-4 py-2 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-blue-800">
                                                    Sửa
                                                </a>
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
