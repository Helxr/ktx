<header class="sticky top-0 z-30 border-b border-ui-border bg-ui-bg/80 backdrop-blur-xl">
    <div class="flex items-center justify-between gap-4 px-6 py-4">
        <!-- Left: Page Title -->
        <div class="flex items-center gap-3 text-sm">
            <div class="font-display text-lg font-black text-ink-primary tracking-tight">PDU ADMIN</div>
            <span class="text-ui-border h-4 border-r"></span>
            <div class="text-ink-secondary font-bold text-sm tracking-wide">@yield('admin_page_title', 'Dashboard')</div>
        </div>

        <!-- Right: Actions & Profile -->
        <div class="flex items-center gap-4">
            <!-- Global Search -->
            <form class="hidden lg:block relative">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-ink-secondary/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                    </svg>
                </div>
                <input type="search" class="w-64 rounded-xl border border-ui-border bg-white py-2 pl-10 pr-4 text-sm font-medium text-ink-primary placeholder:text-ink-secondary/40 focus:border-ink-primary focus:outline-none focus:ring-1 focus:ring-ink-primary transition-all shadow-sm" placeholder="Tìm kiếm nhanh (Ctrl+K)..." />
            </form>

            <span class="text-ui-border h-6 border-r hidden lg:block mx-1"></span>

            <!-- Notifications -->
            <a href="{{ route('admin.quanlythongbao') }}" class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-ui-border text-ink-secondary hover:bg-ui-bg hover:text-ink-primary transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/>
                </svg>
                <span class="absolute top-2.5 right-2.5 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-emerald opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-emerald"></span>
                </span>
            </a>

            <!-- User Menu -->
            <a href="{{ route('profile.edit') }}" class="hidden sm:flex items-center gap-2.5 rounded-xl border border-ui-border bg-white px-3 py-1.5 transition-all hover:bg-ui-bg shadow-sm">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-ink-primary text-[10px] font-black text-white">
                    BQ
                </div>
                <span class="text-sm font-bold text-ink-primary pr-1">Ban quản lý</span>
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 transition-colors" title="Đăng xuất" data-loading-text="...">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</header>
