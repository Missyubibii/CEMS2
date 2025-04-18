<x-app-layout>
    <x-slot name="header">
        {{ __('Quản lý tài khoản') }}
    </x-slot>

    <div class="p-4 sm:ml-64 sm:p-5">
        <div class="overflow-x-auto rounded-lg ">
            {{-- <h2 class="text-lg font-semibold">Danh sách thiết bị</h2> --}}

            <div class="flex flex-col md:flex-row items-center justify-end space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
                    onclick="toggleAddForm()">
                    <button id="add_users_button" data-modal-target="add_users" data-modal-toggle="add_users" type="button"
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="w-3.5 h-3.5 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        Thêm thiết tài khoản
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
                                    Tên tài khoản
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Chức vụ
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Số điện thoại
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Email
                                </th>
                                <th scope="col" class="p-4 text-s tracking-wider text-left text-black uppercase ">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <span class="font-semibold">{{ $user->id }}</span>
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $user->role }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->phone }}
                                    </td>

                                    <td
                                        class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->email }}
                                    </td>

                                    <td class="p-4 whitespace-nowrap">
                                        @if ($user->role === 'Admin')
                                            <span
                                                class="bg-green-400 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $user->role }}
                                            </span>
                                        @else
                                            <span
                                                class="bg-red-400 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md ">
                                                {{ $user->role }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <a href="{{ route('admin.users.edit', $user) }}"
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
                                        <button data-modal-target="deleteModal-{{ $user->id }}"
                                            data-modal-toggle="deleteModal-{{ $user->id }}"
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

                                        <div id="deleteModal-{{ $user->id }}" tabindex="-1"
                                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                            <div class="relative w-full h-full max-w-md md:h-auto">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <div class="p-6 text-center">
                                                        <h3
                                                            class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                            Bạn có chắc chắn muốn xóa tài khoản này?
                                                        </h3>
                                                        <form id="delete-{{ $user->id }}" method="POST"
                                                            class="space-x-2 whitespace-nowrap"
                                                            action="{{ route('admin.users.destroy', $user) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class=" text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm px-5 py-2.5 text-center">
                                                                Xóa
                                                            </button>
                                                            <button type="button"
                                                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                                                                data-modal-hide="deleteModal-{{ $user->id }}">
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
                        </tbody>
                    </table>
                </div>
            </div>

            <form id="add_users" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <!-- Modal header -->
                        <div
                            class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Thêm tài khoản
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="add_users">
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
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                                <!-- Tên tài khoản -->
                                <div class="sm:col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Tên tài khoản</label>
                                    <input type="text" name="name" id="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                        value="{{ old('name') }}" placeholder="Nhập tên tài khoản..." required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Chức vụ -->
                                <div class="sm:col-span-2">
                                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Chức vụ</label>
                                    <select id="role" name="role"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Giáo viên" {{ old('role') == 'Giáo viên' ? 'selected' : '' }}>Giáo viên</option>
                                    </select>
                                    @error('role')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Số điện thoại -->
                                <div class="sm:col-span-2">
                                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Số điện thoại</label>
                                    <input type="text" name="phone" id="phone"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                        value="{{ old('phone') }}" placeholder="Nhập số điện thoại..." required>
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Địa chỉ email -->
                                <div class="sm:col-span-2">
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Địa chỉ email</label>
                                    <input type="email" name="email" id="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                        value="{{ old('email') }}" placeholder="Nhập địa chỉ email..." required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mật khẩu -->
                                <div class="sm:col-span-2">
                                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Mật khẩu</label>
                                    <input type="password" name="password" id="password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                        placeholder="Nhập mật khẩu mới..." required>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Xác nhận mật khẩu -->
                                <div class="sm:col-span-2">
                                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Xác nhận mật khẩu</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                        placeholder="Nhập lại mật khẩu mới..." required>
                                    @error('password_confirmation')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-center space-x-4">
                                    <button type="submit"
                                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        Thêm tài khoản
                                    </button>

                                    <a href="{{ route('admin.users.index') }}"
                                        class="px-5 py-2.5 text-sm font-medium text-gray-900 border rounded-lg bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                                        Hủy
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
