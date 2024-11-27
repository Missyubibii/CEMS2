<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Thay đổi mật khẩu') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Hãy đảm bảo tài khoản của bạn đang sử dụng mật khẩu dài và ngẫu nhiên để giữ an toàn.') }}
        </p>
    </header>

    <x-splade-form method="put" :action="route('password.update')" class="mt-6 space-y-6" preserve-scroll>
        <x-splade-input id="current_password" name="current_password" type="password" :label="__('Mật khẩu hiện tại')" autocomplete="current-password" />
        <x-splade-input id="password" name="password" type="password" :label="__('Mật khẩu mới')" autocomplete="new-password" />
        <x-splade-input id="password_confirmation" name="password_confirmation" type="password" :label="__('Xác nhận lại mật khẩu')" autocomplete="new-password" />

        <div class="flex items-center gap-4">
            <x-splade-submit :label="__('Lưu')" />

            @if (session('status') === 'password-updated')
                <p class="text-base text-green-500">{{ __('Mật khẩu đã được thay đổi') }}</p>
            @endif
        </div>
    </x-splade-form>
</section>
