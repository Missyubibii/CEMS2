<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý phòng học') }}
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

                        Thêm phòng học
                    </button>
                </div>
            </div>
            <div class=" inline-block min-w-full align-middle">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <table class="table-auto w-full mt-4 divide-y divide-gray-200 dark:divide-gray-600">
                        <thead>
                            <tr>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    ID
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Tên phòng học
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Địa chỉ phòng học
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Sức chứa
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Tình trạng
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($rooms as $room)
                                <tr>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <span class="font-semibold">{{ $room->id }}</span>
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $room->room_name }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @if ($room->roomAddress)
                                            Phòng {{ $room->roomAddress->room_name }} -
                                            Tòa {{ $room->roomAddress->building->building_name ?? 'No Building' }} -
                                            {{ $room->roomAddress->campus->campus_name ?? 'No Campus' }}
                                        @else
                                            Không có địa chỉ
                                        @endif
                                    </td>

                                    <td
                                        class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $room->capacity }}
                                    </td>

                                    <td class="p-4 whitespace-nowrap">
                                        @if ($room->status === 'Còn trống')
                                            <span
                                                class="bg-green-400 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $room->status }}
                                            </span>
                                        @elseif ($room->status === 'Đang sử dụng')
                                            <span
                                                class="bg-blue-400 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $room->status }}
                                            </span>
                                        @elseif ($room->status === 'Đang bảo trì')
                                            <span
                                                class="bg-yellow-400 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $room->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <a href="{{ route('admin.rooms.edit', $room) }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                                            <svg class="w-3.5 h-3.5 mr-2 text-gray-300 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            Sửa
                                        </a>
                                        <button
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300"
                                            onclick="document.getElementById('delete-{{ $room->id }}').submit();">
                                            <svg class="w-3.5 h-3.5 mr-2 text-gray-300 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Xóa
                                        </button>
                                        <form id="delete-{{ $room->id }}" method="POST"
                                            action="{{ route('admin.rooms.destroy', $room) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <form id="add_rooms" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <!-- Modal header -->
                        <div
                            class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Thêm phòng học
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="add_rooms">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Đóng cửa sổ</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form method="POST" action="{{ route('admin.rooms.store') }}">
                            @csrf
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div>
                                    <label for="room_name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên phòng
                                        học</label>
                                    <input type="text" id="room_name" name="room_name" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập tên phòng học">
                                </div>

                                <div>
                                    <label for="room_address_id"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Địa chỉ
                                        phòng học</label>
                                    <select id="room_address_id" name="room_address_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Chọn phòng học</option>
                                        @foreach ($roomAddresses as $roomAddress)
                                            <option value="{{ $roomAddress->id }}">
                                                {{ $roomAddress->room_name }} -
                                                {{ $roomAddress->building->building_name ?? 'No Building' }} -
                                                {{ $roomAddress->campus->campus_name ?? 'No Campus' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="capacity"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sức
                                        chứa</label>
                                    <input type="number" id="capacity" name="capacity" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nhập số lượng phòng học">
                                </div>

                                <div>
                                    <label for="status"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng
                                        thái</label>
                                    <select id="status" name="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="Còn trống">Còn trống</option>
                                        <option value="Đang sử dụng">Đang sử dụng</option>
                                        <option value="Đang bảo trì">Đang bảo trì</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Thêm phòng học
                            </button>
                        </form>
                    </div>
                </div>
            </form>

            <!-- Phân trang cho địa chỉ phòng học -->
            <div class="mt-4">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
