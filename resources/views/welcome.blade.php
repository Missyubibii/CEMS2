<div class="bg-white border-gray-500 px-4 lg:px-6 py-2.5">
    <div class="flex justify-between items-center mx-auto max-w-screen-xl">
        <a href="https://flowbite.com" class="flex ml-2 md:mr-24">
            <img src="{{ asset('img/logo.png') }}" class="h-10 mr-4" alt="C.E.M.S Logo" />
            <span
                class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">C.E.M.S</span>
        </a>
        <div class="flex items-center lg:order-2">
            @if (Route::has('login'))
                <div class="flex justify-between items-center mx-auto max-w-screen-xl">
                    @auth
                        <Link
                            href="{{ Auth::user()->role === 'Admin' ? url('/admin/dashboard') : url('/teacher/dashboard') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">
                        Trang chính</Link>
                    @else
                        <Link href="{{ route('login') }}"
                            class="text-gray-800 dark:text-white hover:bg-gray-300 focus:ring-4 focus:ring-gray-600 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">
                        Đăng nhập</Link>

                        @if (Route::has('register'))
                            <Link href="{{ route('register') }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">
                            Đăng ký</Link>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>

<div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <!-- Features -->
    <div class="max-w-[100rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <div class="lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
            <div class="lg:col-span-7">
                <!-- Grid -->
                <div class="grid grid-cols-12 gap-2 sm:gap-6 items-center lg:-translate-x-10">
                    <div class="col-span-4">
                        <img class="rounded-xl"
                            src="https://images.unsplash.com/photo-1606868306217-dbf5046868d2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=920&q=80"
                            alt="Features Image">
                    </div>
                    <!-- End Col -->

                    <div class="col-span-3">
                        <img class="rounded-xl"
                            src="https://images.unsplash.com/photo-1605629921711-2f6b00c6bbf4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=920&q=80"
                            alt="Features Image">
                    </div>
                    <!-- End Col -->

                    <div class="col-span-5">
                        <img class="rounded-xl"
                            src="https://images.unsplash.com/photo-1600194992440-50b26e0a0309?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=920&q=80"
                            alt="Features Image">
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Grid -->
            </div>
            <!-- End Col -->

            <div class="mt-5 sm:mt-10 lg:mt-0 lg:col-span-5">
                <div class="space-y-6 sm:space-y-8">
                    <!-- Title -->
                    <div class="space-y-4 md:space-y-4">
                        <h2 class="font-bold text-3xl lg:text-4xl text-gray-800 ">
                            Hệ thống quản lý, đặt phòng – thiết bị C.E.M.S (Classroom & Equipment Management System)
                        </h2>
                        <p class="text-gray-500 dark:text-neutral-500">
                            Là một giải pháp phần mềm được phát triển để hỗ trợ các trường học, cơ sở đào tạo, và các tổ
                            chức quản lý hiệu quả các phòng học và thiết bị. Hệ thống này cung cấp các công cụ cần thiết
                            để quản lý, theo dõi, và đặt lịch sử dụng phòng học cũng như thiết bị, từ đó tối ưu hóa quy
                            trình sử dụng tài nguyên.
                        </p>
                    </div>
                    <!-- End Title -->

                    <!-- List -->
                    <ul class="space-y-2 sm:space-y-4">
                        <li class="flex gap-x-3">
                            <span
                                class="mt-0.5 w-10 h-10 flex justify-center items-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <div class="grow">
                                <span class="text-sm sm:text-base text-gray-500 dark:text-neutral-500">
                                    <span class="font-bold">Tiết kiệm thời gian</span> – Việc quản lý phòng học và thiết
                                    bị không còn phải thực hiện thủ công, tiết kiệm thời gian cho cả người quản lý và
                                    người sử dụng.
                                </span>
                            </div>
                        </li>

                        <li class="flex gap-x-3">
                            <span
                                class="mt-0.5 w-10 h-10 flex justify-center items-center rounded-full bg-blue-100 text-blue-600 ">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <div class="grow">
                                <span class="text-sm sm:text-base text-gray-500 dark:text-neutral-500">
                                    <span class="font-bold">Giảm thiểu sai sót</span> – Hệ thống giúp hạn chế lỗi do
                                    việc đặt phòng học và thiết bị không chính xác hoặc trùng lặp.
                                </span>
                            </div>
                        </li>

                        <li class="flex gap-x-3">
                            <span
                                class="mt-0.5 w-10 h-10 flex justify-center items-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <div class="grow">
                                <span class="text-sm sm:text-base text-gray-500 dark:text-neutral-500">
                                    <span class="font-bold">Tối ưu hóa tài nguyên</span> – Các tài nguyên phòng học và
                                    thiết bị được sử dụng một cách hiệu quả hơn, giảm thiểu tình trạng lãng phí hoặc
                                    thiếu hụt.
                                </span>
                            </div>
                        </li>

                        <li class="flex gap-x-3">
                            <span
                                class="mt-0.5 w-10 h-10 flex justify-center items-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <div class="grow">
                                <span class="text-sm sm:text-base text-gray-500 dark:text-neutral-500">
                                    <span class="font-bold">Dễ dàng giám sát và báo cáo</span> – Các báo cáo chi tiết
                                    về sử dụng phòng học và thiết bị giúp nhà quản lý dễ dàng theo dõi và có kế hoạch sử
                                    dụng hợp lý.
                                </span>
                            </div>
                        </li>
                    </ul>
                    <!-- End List -->
                    <x-splade-link href="{{ route('about') }}" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                        <span>Tìm hiểu thêm</span>
                    </x-splade-link>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Features -->
</div>
