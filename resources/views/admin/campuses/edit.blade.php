<x-app-layout>
    <x-slot name="header">
        {{ __('Chỉnh sửa Cơ sở') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Sửa thông cơ sở học</h2>
            <form method="POST" action="{{ route('admin.campuses.update', $campus) }}">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div class="sm:col-span-2">
                        <label for="campus_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tên cơ sở học
                        </label>
                        <input type="text" id="campus_name" name="campus_name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('ncampus_name', $campus->campus_name) }}" required
                            placeholder="Nhập tên tòa học..." required>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit"
                        class="text-blue-600 inline-flex items-center hover:text-white border border-blue-600 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <svg class="w-5 h-5 mr-1 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>

                            <a>Lưu thông tin</a>
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-base text-green-500">
                                {{ __('Đã lưu thành công.') }}
                            </p>
                        @endif

                        <button type="button"
                            class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="w-5 h-5 mr-1 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14.5 8.046H11V6.119c0-.921-.9-1.446-1.524-.894l-5.108 4.49a1.2 1.2 0 0 0 0 1.739l5.108 4.49c.624.556 1.524.027 1.524-.893v-1.928h2a3.023 3.023 0 0 1 3 3.046V19a5.593 5.593 0 0 0-1.5-10.954Z" />
                            </svg>

                            <a href="{{ url('/admin/campuses') }}">Hủy</a>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
