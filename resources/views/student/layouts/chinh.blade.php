<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'hethongquanlyktx') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Sans:wght@100..900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <style>
        h1, h2, h3, .font-display { font-family: 'Quicksand', sans-serif !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ui-bg font-sans antialiased text-ink-primary transition-colors duration-300">
@php
    $hoadonCanXuLy = isset($hoadonchuathanhtoan) && method_exists($hoadonchuathanhtoan, 'count') ? $hoadonchuathanhtoan->count() : 0;
    $hotroCanXuLy = $hoadonCanXuLy > 0 ? 1 : 0;
    $tenSinhVien = auth()->user()->name ?? 'Sinh viên';
    $vaitro = auth()->user()->vaitro;
    $isAlumni = $vaitro === 'cuu_sinhvien';
    $mssv = isset($sinhvien) && !empty($sinhvien?->mssv) ? $sinhvien->mssv : ('SV' . str_pad((string) (auth()->id() ?? 0), 6, '0', STR_PAD_LEFT));
@endphp

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-40 hidden w-64 border-r border-ui-border bg-ui-card lg:block">
        <div class="flex h-full flex-col">
            <!-- Brand Logo -->
            <div class="px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-emerald text-slate-100 shadow-lg shadow-brand-emerald/20">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                    </div>
                    <div class="font-display text-2xl font-black tracking-tighter text-ink-primary uppercase">PDU <span class="text-brand-emerald">PORTAL</span></div>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="px-4 mb-6">
                <div class="relative overflow-hidden rounded-2xl bg-ui-bg border border-ui-border p-4 transition-all hover:border-brand-emerald/30">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-emerald/10 font-bold text-brand-emerald ring-1 ring-brand-emerald/20">
                            {{ strtoupper(substr($tenSinhVien, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-xs font-black text-ink-primary uppercase tracking-tight">{{ $tenSinhVien }}</div>
                            <div class="flex items-center gap-1.5 text-[9px] font-bold uppercase tracking-widest text-ink-secondary/60">
                                <span class="h-1 w-1 rounded-full {{ $isAlumni ? 'bg-ink-secondary/30' : 'bg-brand-emerald animate-pulse' }}"></span>
                                {{ $mssv }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto px-4 pb-8 custom-scrollbar">
                <div class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">Hệ thống</div>
                <div class="space-y-0.5">
                    <a href="{{ route('student.trangchu') }}" class="portal-link {{ request()->routeIs('student.trangchu') ? 'portal-link-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"/></svg>
                            <span>Tổng quan</span>
                        </div>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="portal-link {{ request()->routeIs('profile.edit') ? 'portal-link-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Hồ sơ cá nhân</span>
                        </div>
                    </a>
                </div>

                <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">Lưu trú</div>
                <div class="space-y-0.5">
                    @if(!$isAlumni)
                        <a href="{{ route('student.danhsachphong') }}" class="portal-link {{ request()->routeIs('student.danhsachphong') ? 'portal-link-active' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Xem phòng trống</span>
                            </div>
                        </a>
                    @endif
                    <a href="{{ route('student.hopdongcuatoi') }}" class="portal-link {{ request()->routeIs('student.hopdongcuatoi') ? 'portal-link-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>{{ $isAlumni ? 'Lịch sử nội trú' : 'Hợp đồng' }}</span>
                        </div>
                    </a>
                    @if(!$isAlumni)
                        <a href="{{ route('student.phongcuatoi') }}" class="portal-link {{ request()->routeIs('student.phongcuatoi*') ? 'portal-link-active' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Phòng của tôi</span>
                            </div>
                        </a>
                    @endif
                </div>

                <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">Giao dịch</div>
                <div class="space-y-0.5">
                    <a href="{{ route('student.hoadoncuaem') }}" class="portal-link {{ request()->routeIs('student.hoadoncuaem', 'student.phongcuatoi.hoadon.chitiet') ? 'portal-link-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span>Hóa đơn</span>
                        </div>
                        @if ($hoadonCanXuLy > 0)
                            <span class="portal-badge-success bg-rose-500/10 text-rose-600">{{ $hoadonCanXuLy }}</span>
                        @endif
                    </a>
                </div>

                <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">Tiện ích</div>
                <div class="space-y-0.5">
                    @if(!$isAlumni)
                        <a href="{{ route('student.danhsachbaohong') }}" class="portal-link {{ request()->routeIs('student.danhsachbaohong') ? 'portal-link-active' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 012 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Báo hỏng</span>
                            </div>
                        </a>
                    @endif
                    <a href="{{ route('student.kyluatcuaem') }}" class="portal-link {{ request()->routeIs('student.kyluatcuaem') ? 'portal-link-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>Kỷ luật</span>
                        </div>
                    </a>
                    <a href="{{ route('student.thongbao') }}" class="portal-link {{ request()->routeIs('student.thongbao*', 'student.chitietthongbao') ? 'portal-link-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"/></svg>
                            <span>Thông báo</span>
                        </div>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 lg:pl-64">
        <!-- Topbar -->
        <header class="sticky top-0 z-30 border-b border-ui-border bg-ui-bg/80 backdrop-blur-xl">
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="font-display text-3xl font-black tracking-tighter text-ink-primary">
                        @if(isset($title))
                            {{ $title }}
                        @else
                            @yield('student_page_title', 'Dashboard')
                        @endif
                    </h1>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/50">Hệ thống quản lý cư trú PDU</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('student.thongbao') }}" class="flex h-10 w-10 items-center justify-center rounded-xl border border-ui-border bg-ui-card text-ink-secondary hover:bg-ui-bg hover:text-ink-primary transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.4-1.4a2 2 0 0 1-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/></svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="pdu-btn-primary h-10">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 pb-24 lg:pb-12">
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-error/20 bg-error/5 p-4 text-sm text-error">
                    <div class="flex items-center gap-2 font-bold mb-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Phát hiện lỗi nhập liệu:</span>
                    </div>
                    <ul class="list-inside list-disc space-y-1 pl-7">
                        @foreach ($errors->all() as $loi)
                            <li>{{ $loi }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="animate-fade-in-up">
                @yield('noidung')
                {{ $slot ?? '' }}
            </div>
        </main>
    </div>

    <x-toast />

    <!-- Mobile Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-ui-border bg-ui-bg/90 p-2 backdrop-blur-xl lg:hidden">
        <div class="mx-auto flex w-full max-w-lg items-center justify-between px-2">
            <a href="{{ route('student.trangchu') }}" class="flex flex-col items-center gap-1 rounded-xl px-3 py-1.5 text-[10px] font-bold uppercase tracking-tighter {{ request()->routeIs('student.trangchu') ? 'text-brand-emerald' : 'text-ink-secondary' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V12H9v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9z"/></svg>
                Home
            </a>
            <a href="{{ route('student.hoadoncuaem') }}" class="flex flex-col items-center gap-1 rounded-xl px-3 py-1.5 text-[10px] font-bold uppercase tracking-tighter {{ request()->routeIs('student.hoadoncuaem', 'student.phongcuatoi.hoadon.chitiet') ? 'text-brand-emerald' : 'text-ink-secondary' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-6m0 0V9a2 2 0 1 1 4 0v2m0 2v6M5 11h14" /></svg>
                Bill
            </a>
            <a href="{{ route('student.danhsachbaohong') }}" class="flex flex-col items-center gap-1 rounded-xl px-3 py-1.5 text-[10px] font-bold uppercase tracking-tighter {{ request()->routeIs('student.danhsachbaohong') ? 'text-brand-emerald' : 'text-ink-secondary' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3M6.5 19h11a2.5 2.5 0 0 0 2.5-2.5V6.5A2.5 2.5 0 0 0 17.5 4h-11A2.5 2.5 0 0 0 4 6.5v10A2.5 2.5 0 0 0 6.5 19z"/></svg>
                Repair
            </a>
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 rounded-xl px-3 py-1.5 text-[10px] font-bold uppercase tracking-tighter {{ request()->routeIs('profile.edit') ? 'text-brand-emerald' : 'text-ink-secondary' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A4 4 0 0 1 8 13h8a4 4 0 0 1 2.879 4.804M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0z"/></svg>
                Profile
            </a>
        </div>
    </nav>
</div>
</body>
</html>
