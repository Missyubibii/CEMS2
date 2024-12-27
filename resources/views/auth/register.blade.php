<div class="flex flex-wrap space-x-20 items-center justify-center min-h-screen px-4 py-6 ">
    <!-- Left Section -->
    <div class="w-full mb-8 md:w-1/2 md:mb-0">
        <h1 class="mb-4 text-4xl font-bold text-gray-800">
            Hệ thống quản lý, đặt phòng – thiết bị C.E.M.S (Classroom & Equipment Management System)
        </h1>
        <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
            Là một giải pháp phần mềm được phát triển để hỗ trợ các trường học, cơ sở đào tạo, và các tổ chức quản lý
            hiệu quả các phòng học và thiết bị. Hệ thống này cung cấp các công cụ cần thiết để quản lý, theo dõi, và đặt
            lịch sử dụng phòng học cũng như thiết bị, từ đó tối ưu hóa quy trình sử dụng tài nguyên.
        </p>
        <x-splade-link href="{{ route('about') }}"
            class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
            <span>Tìm hiểu thêm</span>
        </x-splade-link>
    </div>

    <!-- Right Section (Sign-up Form) -->
    <div class="w-full md:w-1/4">
        <div class="p-10 bg-gray-50 rounded-lg shadow-xl">
            <h1 class="justify-between mb-4 text-2xl font-bold text-gray-800">
                Đăng ký tài khoản
            </h1>
            <x-splade-form action="{{ route('register') }}" class="space-y-4">
                <x-splade-input class="mb-5 text-sm font-medium text-gray-900 " id="name" type="text"
                    name="name" :label="__('Họ và tên')" required autofocus />
                <x-splade-input class="mb-5 text-sm font-medium text-gray-900 " id="phone" name="phone"
                    :label="__('Số điện thoại')" required autofocus />
                <x-splade-input class="mb-5 text-sm font-medium text-gray-900 " id="email" type="email"
                    name="email" :label="__('Địa chỉ Email')" required />
                <x-splade-input class="mb-5 text-sm font-medium text-gray-900 " id="password" type="password"
                    name="password" :label="__('Mật khẩu')" required autocomplete="new-password" />
                <x-splade-input class="mb-5 text-sm font-medium text-gray-900 " id="password_confirmation"
                    type="password" name="password_confirmation" :label="__('Xác nhận lại mật khẩu')" required />

                <x-splade-submit
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full"
                    :label="__('Đăng ký tài khoản')" />

                <p class="mt-4 text-sm text-center text-gray-600">
                    Đã có tài khoản?
                    <Link href="{{ route('login') }}" class="text-blue-600 hover:underline">Đăng nhập
                    </Link>
                </p>
            </x-splade-form>
        </div>
    </div>
</div>
