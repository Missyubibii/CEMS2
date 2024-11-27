<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Thông tin cá nhân') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản.") }}
        </p>
    </header>

    <x-splade-form method="patch" :action="route('profile.update')" :default="$user" class="mt-6 space-y-6" preserve-scroll>
        <x-splade-input id="name" name="name" type="text" :label="__('tên tài khoản')" required autofocus autocomplete="Tên tài khoản" />
        <x-splade-input id="role" name="role" type="text" :label="__('Chức vụ')" :value="$user->role" disabled/>
        <x-splade-input id="phone" name="phone" type="text" :label="__('Số điện thoại')" required autofocus autocomplete="Số điện thoại" />
        <x-splade-input id="email" name="email" type="email" :label="__('Địa chỉ email')" required autocomplete="Địa chỉ email" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Địa chỉ email của bạn chưa được xác minh.') }}

                    <Link method="post" href="{{ route('verification.send') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Nhấn vào đây để gửi lại email xác minh.') }}
                    </Link>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-splade-submit :label="__('Lưu')" />

            @if (session('status') === 'profile-updated')
                <p class="text-base text-green-500">
                    {{ __('Đã lưu thành công.') }}
                </p>
            @endif
        </div>
    </x-splade-form>
</section>
