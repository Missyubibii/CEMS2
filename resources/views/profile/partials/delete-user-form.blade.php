<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Xóa tài khoản') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Sau khi tài khoản của bạn bị xóa, tất cả tài nguyên và dữ liệu của tài khoản đó sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.') }}
        </p>
    </header>

     <x-splade-form
        method="delete"
        :action="route('profile.destroy')"
        :confirm="__('Bạn có chắc chắn muốn xóa tài khoản này?')"
        :confirm-text="__('Sau khi tài khoản của bạn bị xóa, tất cả tài nguyên và dữ liệu của tài khoản đó sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.')"
        :confirm-button="__('Xóa tài khoản?')"
        require-password
    >
        <x-splade-submit danger :label="__('Xóa tài khoản')" />
    </x-splade-form>
</section>
