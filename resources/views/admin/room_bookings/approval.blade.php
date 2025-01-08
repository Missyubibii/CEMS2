<x-app-layout>
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
                                {{ $roomBooking->status }}
                            </td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                @if ($roomBooking->status === 'Chờ duyệt')
                                    <form method="POST" action="{{ route('admin.room_bookings.updateStatus', $roomBooking->id) }}" class="inline-block">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" name="status" value="Đang sử dụng"
                                            class="px-3 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-green-300">
                                            Duyệt
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.room_bookings.updateStatus', $roomBooking->id) }}" class="inline-block">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" name="status" value="Từ chối duyệt"
                                            class="px-3 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300">
                                            Từ chối
                                        </button>
                                    </form>
                                @elseif ($roomBooking->status === 'Đang sử dụng')
                                    <form method="POST" action="{{ route('admin.room_bookings.updateStatus', $roomBooking->id) }}" class="inline-block">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" name="status" value="Đã trả phòng"
                                            class="px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                                            Đã trả phòng
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
