<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý đơn đặt phòng') }}
    </x-slot>

    <div class="p-4 sm:ml-64 sm:p-5">
        <div class="overflow-x-auto rounded-lg ">

            <div class="flex flex-col md:flex-row items-center justify-end space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <button id="add_rooms_button" data-modal-target="add_rooms" data-modal-toggle="add_rooms" type="button"
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="w-3.5 h-3.5 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        Đặt phòng - thiết bị
                    </button>
                </div>
            </div>

            <div class="inline-block min-w-full align-middle">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <table class="table-auto w-full mt-4 divide-y divide-gray-200 dark:divide-gray-600">
                        <thead>
                            <tr>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">ID
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">Tên
                                    tài khoản</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">Tên
                                    phòng</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">Địa
                                    chỉ phòng</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">
                                    Thiết bị</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">Thời
                                    gian đặt phòng</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">Mục
                                    đích sử dụng</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">
                                    Trạng thái phòng</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">
                                    Trạng thái đơn đặt</th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase">Hành
                                    động</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($roomBookings as $booking)
                                <tr>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <span class="font-semibold">{{ $booking->id }}</span>
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $booking->user->name }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $booking->room->room_name }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        Phòng {{ $booking->roomAddress->room_name }} -
                                        Tòa {{ $booking->roomAddress->building->building_name ?? 'No Building' }} -
                                        {{ $booking->roomAddress->campus->campus_name ?? 'No Campus' }}
                                    </td>
                                    <td>
                                        @if ($booking->devices->isEmpty())
                                            Không có thiết bị
                                        @else
                                            <ul>
                                                @foreach ($booking->devices as $device)
                                                    <li>{{ $device->device_name }} - {{ $device->category }} - Số lượng:
                                                        {{ $device->pivot->quantity }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td
                                        class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ optional($booking->startPeriod)->name }} -
                                        {{ optional($booking->endPeriod)->name }}
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $booking->purpose }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @if ($booking->room->status === 'Còn trống')
                                            <span
                                                class="bg-green-400 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                {{ $booking->room->status }}
                                            </span>
                                        @elseif ($booking->room->status === 'Đang sử dụng')
                                            <span
                                                class="bg-blue-400 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                {{ $booking->room->status }}
                                            </span>
                                        @elseif ($booking->room->status === 'Đang bảo trì')
                                            <span
                                                class="bg-yellow-400 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                {{ $booking->room->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <!-- Kiểm tra trạng thái đơn đặt -->
                                        @if ($booking->status == 'Chờ duyệt')
                                            <!-- Giáo viên thấy trạng thái "Chờ duyệt" -->
                                            <span
                                                class="bg-green-400 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                Chờ duyệt
                                            </span>
                                        @elseif($booking->status == 'Đang sử dụng')
                                            <!-- Giáo viên thấy trạng thái "Đang sử dụng" -->
                                            <span
                                                class="bg-blue-400 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                Đang sử dụng
                                            </span>
                                        @elseif($booking->status == 'Đã trả phòng')
                                            <!-- Giáo viên thấy trạng thái "Đã trả phòng" -->
                                            <span
                                                class="bg-gray-400 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                Đã trả phòng
                                            </span>
                                        @elseif($booking->status == 'Từ chối duyệt')
                                            <!-- Giáo viên thấy trạng thái "Từ chối duyệt" -->
                                            <span
                                                class="bg-red-400 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                Từ chối duyệt
                                            </span>
                                        @endif

                                        <!-- Giáo viên có thể nhấn "Trả phòng" -->
                                        @if (auth()->user()->role == 'Giáo viên' && $booking->status == 'Đang sử dụng')
                                            <a href="{{ route('teacher.room_bookings.updateStatus', ['id' => $booking->id, 'status' => 'Đã trả phòng']) }}"
                                                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg ml-2">
                                                Trả phòng
                                            </a>
                                        @endif
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <!-- Admin thấy trạng thái đơn đặt và có các nút thao tác -->
                                        @if (auth()->user()->role == 'Admin')
                                            @if ($booking->status == 'Chờ duyệt')
                                                <!-- Admin có thể duyệt hoặc từ chối -->
                                                <a href="{{ route('admin.room_bookings.updateStatus', ['id' => $booking->id, 'status' => 'Đang sử dụng']) }}"
                                                    class="bg-green-500 hover:bg-green-600 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                    Duyệt
                                                </a>
                                                <a href="{{ route('admin.room_bookings.updateStatus', ['id' => $booking->id, 'status' => 'Từ chối duyệt']) }}"
                                                    class="bg-red-500 hover:bg-red-600 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                    Từ chối duyệt
                                                </a>
                                            @elseif($booking->status == 'Đang sử dụng')
                                                <!-- Admin không thể duyệt lại, chỉ có thể từ chối hoặc chỉnh sửa -->
                                                <a href="{{ route('admin.room_bookings.updateStatus', ['id' => $booking->id, 'status' => 'Đã trả phòng']) }}"
                                                    class="bg-blue-500 hover:bg-blue-600 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                    Đã trả phòng
                                                </a>
                                            @elseif($booking->status == 'Từ chối duyệt')
                                                <!-- Admin thấy trạng thái từ chối duyệt, không có nút nào khác -->
                                                <span
                                                    class="bg-red-400 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                                                    Từ chối duyệt
                                                </span>
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <form id="add_rooms" tabindex="-1" aria-hidden="true"
                class="hidden fixed top-0 left-0 w-full h-full items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="relative w-full max-w-2xl bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex justify-between items-center p-4 border-b dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Đặt phòng - thiết bị học</h3>
                        <button type="button"
                            class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm p-1.5 ml-auto dark:hover:text-white dark:hover:bg-gray-600"
                            data-modal-toggle="add_rooms">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Đóng</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.room_bookings.store') }}">
                        @csrf
                        <div class="p-4 grid gap-4 sm:grid-cols-2">
                            <!-- Tên phòng học -->
                            <div>
                                <label for="room_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên phòng
                                    học</label>
                                <select id="room_id" name="room_id" required
                                    class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Chọn phòng học</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Địa chỉ phòng học -->
                            <div>
                                <label for="room_address_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Địa chỉ phòng
                                    học</label>
                                <select id="room_address_id" name="room_address_id" required
                                    class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Chọn địa chỉ phòng</option>
                                    @foreach ($roomAddresses as $roomAddress)
                                        <option value="{{ $roomAddress->id }}">{{ $roomAddress->room_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tiết học -->
                            <div>
                                <label for="start_period_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tiết học bắt
                                    đầu</label>
                                <select id="start_period_id" name="start_period_id" required
                                    class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Chọn tiết bắt đầu</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="end_period_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tiết học kết
                                    thúc</label>
                                <select id="end_period_id" name="end_period_id" required
                                    class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Chọn tiết kết thúc</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Mục đích -->
                            <div>
                                <label for="purpose"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mục đích sử
                                    dụng</label>
                                <textarea id="purpose" name="purpose" required rows="4"
                                    class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600"></textarea>
                            </div>

                            <!-- Thiết bị -->
                            <div class="sm:col-span-2">
                                <label
                                    class="flex items-center mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="checkbox" id="enable_devices" class="mr-2">
                                    Chọn thiết bị
                                </label>
                                <div id="devices_section" class="hidden">
                                    @foreach ($devices as $device)
                                        <div class="flex items-center mb-2">
                                            <input type="checkbox" name="devices[{{ $device->id }}][selected]"
                                                value="on">
                                            <span class="ml-2">{{ $device->device_name }}</span>
                                            <input type="number" name="devices[{{ $device->id }}][quantity]"
                                                min="1" value="1"
                                                class="ml-auto w-20 p-2 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end p-4">
                            <button type="submit"
                                class="px-5 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800">Đặt
                                phòng</button>
                        </div>
                    </form>
                </div>
            </form>


            <!-- Phân trang cho địa chỉ phòng học -->
            <div class="mt-4">
                {{ $roomBookings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
