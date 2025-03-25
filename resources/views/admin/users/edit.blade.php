<x-app-layout>
    <x-slot name="header">
        {{ __('Chỉnh sửa tài khoản') }}
    </x-slot>

    <section class="p-4 sm:ml-64">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-900">Sửa thông tin tài khoản</h2>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tên tài khoản -->
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Tên tài khoản</label>
                    <input type="text" name="name" id="name"
                        class="block w-full p-2.5 text-sm border rounded-lg bg-gray-50 border-gray-300 focus:ring-blue-600 focus:border-blue-600"
                        value="{{ old('name', $user->name) }}" placeholder="Nhập tên tài khoản..." required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Chức vụ -->
                <div class="mb-4">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Chức vụ</label>
                    <select id="role" name="role"
                        class="block w-full p-2.5 text-sm border rounded-lg bg-gray-50 border-gray-300 focus:ring-blue-600 focus:border-blue-600">
                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Giáo viên" {{ $user->role == 'Giáo viên' ? 'selected' : '' }}>Giáo viên</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="mb-4">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Số điện thoại</label>
                    <input type="text" name="phone" id="phone"
                        class="block w-full p-2.5 text-sm border rounded-lg bg-gray-50 border-gray-300 focus:ring-blue-600 focus:border-blue-600"
                        value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại..." required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-10">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Địa chỉ email</label>
                    <input type="email" name="email" id="email"
                        class="block w-full p-2.5 text-sm border rounded-lg bg-gray-50 border-gray-300 focus:ring-blue-600 focus:border-blue-600"
                        value="{{ old('email', $user->email) }}" placeholder="Nhập địa chỉ email..." required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <h2 class="mb-4 text-xl font-bold text-gray-900">Thay đổi mật khẩu</h2>

                <!-- Thay đổi mật khẩu -->
                <div class="mb-4">
                    <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" id="current_password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                        placeholder="Nhập mật khẩu hiện tại..." required>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Mật khẩu</label>
                    <input type="password" name="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                        placeholder="Nhập mật khẩu mới..." required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Xác nhận mật
                        khẩu</label>
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
                        Lưu thông tin
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-900 border rounded-lg bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                        Trở về
                    </a>
                </div>

                <!-- Thông báo lưu thành công -->
                @if (session('status') === 'profile-updated')
                    <p class="mt-4 text-sm text-green-500">
                        {{ __('Đã lưu thành công.') }}
                    </p>
                @endif
            </form>
        </div>
    </section>
</x-app-layout>
