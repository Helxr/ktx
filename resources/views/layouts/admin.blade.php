<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }} - Admin KTX</title>

    <link href="https://fonts.googleapis.com/css2?family=Geist+Sans:wght@100..900&family=DM+Sans:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ui-bg font-sans antialiased text-ink-primary">
    <div class="linear-shell flex min-h-screen">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <div class="flex-1 lg:pl-64">
            <!-- Navbar -->
            @include('admin.partials.navbar')

            <main class="animate-fade-up p-4 pb-24 sm:p-6 lg:p-8 lg:pb-12">
                <!-- Breadcrumbs Slot or Component -->
                <div class="mb-6">
                    @if(isset($breadcrumbs))
                        {{ $breadcrumbs }}
                    @else
                        <x-breadcrumbs />
                    @endif
                </div>

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50/50 p-4 text-sm text-rose-700 backdrop-blur-sm">
                        <div class="flex items-center gap-2 font-bold mb-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Phát hiện lỗi nhập liệu:</span>
                        </div>
                        <ul class="list-inside list-disc space-y-1 pl-7 opacity-90">
                            @foreach ($errors->all() as $loi)
                                <li>{{ $loi }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="fixed top-6 right-6 z-[100] animate-pop-in">
                        <div class="flex items-center gap-3 rounded-2xl border border-brand-emerald/20 bg-ui-card px-6 py-4 text-sm font-bold text-brand-emerald shadow-xl shadow-brand-emerald/10 backdrop-blur-md">
                            <svg class="h-6 w-6 text-brand-jade" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-ink-secondary/40 hover:text-ink-primary">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Main Content -->
                <div class="relative">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <x-toast />

        <!-- Mobile Bottom Nav -->
        <nav class="linear-navbar-glass fixed bottom-0 left-0 right-0 z-50 border-t border-ui-border p-2 lg:hidden">
            <div class="mx-auto flex w-full max-w-lg items-center justify-between">
                <a href="{{ route('admin.trangchu') }}" class="flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 text-[10px] font-black uppercase tracking-tighter {{ request()->routeIs('admin.trangchu') ? 'text-brand-emerald bg-brand-emerald/5' : 'text-ink-secondary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>
                <a href="{{ route('admin.quanlyhoadon') }}" class="flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 text-[10px] font-black uppercase tracking-tighter {{ request()->routeIs('admin.quanlyhoadon') ? 'text-brand-emerald bg-brand-emerald/5' : 'text-ink-secondary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m0 0V9a2 2 0 1 1 4 0v2m0 2v6M5 11h14" />
                    </svg>
                    Bills
                </a>
                <a href="{{ route('admin.quanlybaohong') }}" class="flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 text-[10px] font-black uppercase tracking-tighter {{ request()->routeIs('admin.quanlybaohong') ? 'text-brand-emerald bg-brand-emerald/5' : 'text-ink-secondary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Issues
                </a>
                <a href="{{ route('admin.quanlysinhvien') }}" class="flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 text-[10px] font-black uppercase tracking-tighter {{ request()->routeIs('admin.quanlysinhvien') ? 'text-brand-emerald bg-brand-emerald/5' : 'text-ink-secondary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Users
                </a>
            </div>
        </nav>
    </div>
    @stack('modals')
    @stack('scripts')
</body>
</html>
