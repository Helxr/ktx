@php
    $itemBase = 'group mt-1.5 flex items-center justify-between rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200';
    $itemDefault = 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary';
    $itemActive = 'bg-ui-bg text-ink-primary ring-1 ring-ui-border';

    $soDonChoDuyet = isset($dangkychoxuly) ? (int) $dangkychoxuly : null;
    $soSuCoMo = isset($baohongchosua) ? (int) $baohongchosua : null;
    $soCongNo = isset($hoadonchuathanhtoan) ? (int) $hoadonchuathanhtoan : null;

    $tenNguoiDung = auth()->user()->name ?? 'Ban quản lý';
    $chuCaiDau = strtoupper(substr($tenNguoiDung, 0, 1));
@endphp

<aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 bg-ui-card lg:block border-r border-ui-border">
    <div class="flex h-full flex-col">
        <div class="px-5 py-7">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-ink-primary text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                </div>
                <div class="font-display text-xl font-black tracking-tight text-ink-primary">PDU <span class="text-brand-emerald">KTX</span></div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-4 custom-scrollbar">
            <!-- Hệ thống -->
            <div class="mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Hệ thống</div>
            <div class="space-y-0.5">
                <a href="{{ route('admin.trangchu') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.trangchu') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.trangchu') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </div>

            <!-- Quản lý -->
            <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Quản lý</div>
            <div class="space-y-0.5">
                <a href="{{ route('admin.quanlyphong') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlyphong', 'admin.chitietphong') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlyphong', 'admin.chitietphong') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                        <span>Phòng & Tài sản</span>
                    </div>
                </a>
                <a href="{{ route('admin.phong.map') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.phong.map') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.phong.map') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.488V5.488a2 2 0 011.553-1.944L9 2l6 3 5.447-2.724A2 2 0 0121 4.224v10a2 2 0 01-1.553 1.944L15 19l-6 1z"/></svg>
                        <span>Sơ đồ KTX</span>
                    </div>
                </a>
                <a href="{{ route('admin.quanlysinhvien') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlysinhvien') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlysinhvien') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Sinh viên</span>
                    </div>
                </a>
                <a href="{{ route('admin.duyetdangky') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.duyetdangky') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.duyetdangky') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Hồ sơ đăng ký</span>
                    </div>
                    @if (!is_null($soDonChoDuyet) && $soDonChoDuyet > 0)
                        <span class="rounded-md bg-amber-500 px-2 py-0.5 text-[9px] font-black text-white shadow-sm">{{ $soDonChoDuyet }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.quanlyhopdong') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlyhopdong', 'admin.hopdong.*') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlyhopdong', 'admin.hopdong.*') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
                        <span>Hợp đồng</span>
                    </div>
                </a>
            </div>

            <!-- Tài chính -->
            <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Tài chính</div>
            <div class="space-y-0.5">
                <a href="{{ route('admin.quanlyhoadon') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlyhoadon', 'admin.hoadon.*') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlyhoadon', 'admin.hoadon.*') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <span>Hóa đơn điện nước</span>
                    </div>
                </a>
                <a href="{{ route('admin.baocaocongno') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.baocaocongno') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.baocaocongno') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Báo cáo nợ</span>
                    </div>
                    @if (!is_null($soCongNo) && $soCongNo > 0)
                        <span class="rounded-md bg-amber-500 px-2 py-0.5 text-[9px] font-black text-white shadow-sm">{{ $soCongNo }}</span>
                    @endif
                </a>
            </div>

            <!-- Vận hành -->
            <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Vận hành</div>
            <div class="space-y-0.5">
                <a href="{{ route('admin.quanlybaohong') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlybaohong') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlybaohong') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Báo hỏng</span>
                    </div>
                    @if (!is_null($soSuCoMo) && $soSuCoMo > 0)
                        <span class="rounded-md bg-rose-500 px-2 py-0.5 text-[9px] font-black text-white shadow-sm">{{ $soSuCoMo }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.quanlybaotri') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlybaotri') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlybaotri') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        <span>Lịch bảo trì</span>
                    </div>
                </a>
                <a href="{{ route('admin.quanlykyluat') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlykyluat') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlykyluat') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Kỷ luật</span>
                    </div>
                </a>
            </div>

            <!-- Khác -->
            <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Khác</div>
            <div class="space-y-0.5">
                <a href="{{ route('admin.quanlythongbao') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlythongbao') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlythongbao') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4a2 2 0 0 1-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/></svg>
                        <span>Thông báo</span>
                    </div>
                </a>
                <a href="{{ route('admin.quanlylienhe') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlylienhe') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlylienhe') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <span>Hộp thư góp ý</span>
                    </div>
                </a>
                <a href="{{ route('admin.quanlycauhinh') }}" class="group flex items-center justify-between rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.quanlycauhinh') ? 'bg-ink-primary text-white' : 'text-ink-secondary hover:bg-ui-bg hover:text-ink-primary' }}">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.quanlycauhinh') ? 'text-white' : 'text-ink-secondary/50 group-hover:text-ink-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Cài đặt hệ thống</span>
                    </div>
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-ui-border bg-ui-bg/30">
            <div class="flex items-center gap-3 rounded-lg bg-white p-3 border border-ui-border">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-ink-primary font-black text-white">
                    {{ $chuCaiDau }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="truncate text-sm font-bold text-ink-primary font-display tracking-tight">{{ $tenNguoiDung }}</div>
                    <div class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-brand-emerald mt-0.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald animate-pulse"></span>
                        Admin
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
