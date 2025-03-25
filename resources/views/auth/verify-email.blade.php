<x-guest-layout>
    <x-auth-card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, bạn vui lòng xác minh địa chỉ email của mình bằng cách nhấp vào liên kết mà chúng tôi vừa gửi qua email. Nếu bạn không nhận được email, chúng tôi sẵn sàng gửi lại cho bạn.') }}
        </div>

        @if (session('status') == 'Liên kết xác minh đã được gửi')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email mà bạn đã cung cấp trong quá trình đăng ký.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <x-splade-form action="{{ route('verification.send') }}">
                <x-splade-submit :label="__('Gửi lại email xác minh.')" />
            </x-splade-form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Đăng xuất') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
