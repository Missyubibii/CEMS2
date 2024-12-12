<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý phòng học') }}
    </x-slot>

    <div class="p-4 sm:ml-64 sm:p-5">
        <div class="overflow-x-auto rounded-lg ">

            <div class="flex flex-col md:flex-row items-center justify-end space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <a href="{{ route('admin.rooms.store') }}" id="add_rooms_button" type="button"
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="w-3.5 h-3.5 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        Thêm phòng học
                    </a>
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
                            @if ($rooms->isEmpty())
                                <p>Chưa có phòng học nào.</p>
                            @else
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="font-semibold">{{ $room->id }}</span>
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $room->room_name }}
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            Tòa {{ $room->building->building_name ?? 'No Building' }} -
                                            {{ $room->campus->campus_name ?? 'No Campus' }}
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
                                            <button data-modal-target="deleteModal-{{ $room->id }}"
                                                data-modal-toggle="deleteModal-{{ $room->id }}"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300">
                                                <svg class="w-3.5 h-3.5 mr-2 text-gray-300 dark:text-white"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Xóa
                                            </button>

                                            <div id="deleteModal-{{ $room->id }}" tabindex="-1"
                                                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                                <div class="relative w-full h-full max-w-md md:h-auto">
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <div class="p-6 text-center">
                                                            <h3
                                                                class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                                Bạn có chắc chắn muốn xóa phòng này?
                                                            </h3>
                                                            <form id="delete-{{ $room->id }}" method="POST"
                                                                class="space-x-2 whitespace-nowrap"
                                                                action="{{ route('admin.rooms.destroy', $room) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class=" text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm px-5 py-2.5 text-center">
                                                                    Xóa
                                                                </button>
                                                                <button type="button"
                                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                                                                    data-modal-hide="deleteModal-{{ $room->id }}">
                                                                    Hủy
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Phân trang cho địa chỉ phòng học -->
            <div class="mt-4">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
