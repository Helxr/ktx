<nav x-data="{ open: false }" class="border-b border-gray-200/70 bg-ui-card">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-14 items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="shrink-0">
                    <a href="{{ Auth::check() ? route('dashboard') : route('home') }}">
                        <x-application-logo class="h-10" />
                    </a>
                </div>

                <div class="hidden items-center gap-5 sm:flex">
                    <x-nav-link :href="Auth::check() ? route('dashboard') : route('home')" :active="request()->routeIs('dashboard') || request()->routeIs('home')">
                        Trang chủ
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden items-center sm:flex">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-md border border-gray-200/80 bg-ui-card px-3 py-1.5 text-sm font-medium text-[#606060] transition hover:bg-[#F7F7F8] hover:text-[#121212] focus:outline-none">
                            <span>{{ Auth::user()->name ?? 'Khách' }}</span>
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                            <x-dropdown-link :href="route('profile.edit')">
                                Hồ sơ
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">
                                Đăng nhập
                            </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-1 flex items-center sm:hidden">
                <button @click="open = ! open" aria-label="Mở hoặc đóng menu điều hướng" class="inline-flex items-center justify-center rounded-md border border-gray-200/80 bg-ui-card p-2 text-[#606060] transition hover:bg-[#F7F7F8] hover:text-[#121212] focus:outline-none">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-gray-200/70 bg-ui-card sm:hidden">
        <div class="space-y-1 px-4 py-3">
            <x-responsive-nav-link :href="Auth::check() ? route('dashboard') : route('home')" :active="request()->routeIs('dashboard') || request()->routeIs('home')">
                Trang chủ
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200/70 px-4 py-3">
            @auth
                <div class="text-sm font-medium text-[#121212]">{{ Auth::user()->name ?? 'Người dùng' }}</div>
                <div class="text-sm text-[#606060]">{{ Auth::user()->email ?? '' }}</div>
            @endauth

            @auth
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Hồ sơ
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        Đăng nhập
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
