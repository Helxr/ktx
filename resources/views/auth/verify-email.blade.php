<x-guest-layout>
    <div class="mb-4 text-sm text-[#606060]">
        Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác thực email bằng liên kết vừa được gửi.
        Nếu bạn chưa nhận được email, chúng tôi sẽ gửi lại.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-[#606060]">
            Liên kết xác thực mới đã được gửi tới email của bạn.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Gửi lại email xác thực
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-[#606060] hover:text-[#121212] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/10">
                Đăng xuất
            </button>
        </form>
    </div>
</x-guest-layout>
