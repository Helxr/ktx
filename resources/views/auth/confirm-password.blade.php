<x-guest-layout>
    <div class="mb-4 text-sm text-[#606060]">
        Khu vực an toàn. Vui lòng xác nhận lại mật khẩu để tiếp tục.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Mật khẩu" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                Xác nhận
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
