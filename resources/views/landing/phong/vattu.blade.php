<x-app-layout>

<div class="min-h-screen bg-slate-50/50">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-zinc-500">
            <a href="{{ route('public.danhsachphong') }}" class="hover:text-brand-600 transition-colors">Danh sach phong</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-900 font-medium">{{ $phong->tenphong }}</span>
        </nav>

        {{-- Room Info Header --}}
        <div class="linear-card mb-6">
            <div class="p-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-2xl font-bold text-slate-900">Phong {{ $phong->tenphong }}</h1>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-semibold {{ $sochocontrong > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                <span class="h-2 w-2 rounded-full {{ $sochocontrong > 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $sochocontrong > 0 ? 'Con ' . $sochocontrong . ' cho trong' : 'Da day' }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-4 text-sm">
                            <span class="flex items-center gap-1 text-zinc-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Tang {{ $phong->tang }}
                            </span>
                            <span class="flex items-center gap-1 text-zinc-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ $soluongdango }} nguoi dang o
                            </span>
                            <span class="flex items-center gap-1 {{ $phong->gioitinh === 'Nu' ? 'text-pink-600' : 'text-blue-600' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $phong->gioitinh }}
                            </span>
                            <span class="flex items-center gap-1 text-zinc-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ number_format($phong->giaphong, 0, ',', '.') }}đ/thang
                            </span>
                        </div>
                    </div>
                    @if($phong->mota)
                        <p class="text-sm text-zinc-600 max-w-md">{{ $phong->mota }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Vat Tu Section --}}
        <div class="mb-6">
            <h2 class="linear-section-title mb-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Danh sach vat tu ({{ $vattu->count() }})
            </h2>

            @if($vattu->count() > 0)
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($vattu as $item)
                        <div class="linear-card p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-brand-50 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $item->tenvattu }}</h3>
                                    <p class="text-xs text-zinc-500 mt-1">So luong: {{ $item->soluong }}</p>
                                    <span class="inline-flex mt-2 items-center rounded-full px-2 py-0.5 text-xs font-medium
                                        @if($item->tinhtrang === 'Hoat dong tot') bg-emerald-50 text-emerald-700
                                        @elseif($item->tinhtrang === 'Can sua') bg-amber-50 text-amber-700
                                        @else bg-red-50 text-red-700 @endif">
                                        {{ $item->tinhtrang }}
                                    </span>
                                    @if($item->mota)
                                        <p class="text-xs text-zinc-500 mt-2 line-clamp-2">{{ $item->mota }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="linear-panel py-8 text-center">
                    <svg class="mx-auto h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="mt-2 text-sm text-zinc-500">Chua co vat tu nao duoc ghi nhan.</p>
                </div>
            @endif
        </div>

        {{-- Tai San Section --}}
        @if($taisan->count() > 0)
            <div class="mb-6">
                <h2 class="linear-section-title mb-4">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Tai san khac ({{ $taisan->count() }})
                </h2>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($taisan as $item)
                        <div class="linear-card p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-slate-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $item->tentaisan }}</h3>
                                    <p class="text-xs text-zinc-500 mt-1">So luong: {{ $item->soluong }}</p>
                                    <span class="inline-flex mt-2 items-center rounded-full px-2 py-0.5 text-xs font-medium
                                        @if($item->tinhtrang === 'Dang su dung') bg-emerald-50 text-emerald-700
                                        @elseif($item->tinhtrang === 'Can sua') bg-amber-50 text-amber-700
                                        @else bg-zinc-100 text-zinc-600 @endif">
                                        {{ $item->tinhtrang }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Back Button --}}
        <div class="flex justify-center">
            <a href="{{ route('public.danhsachphong') }}" class="linear-btn-secondary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lai danh sach phong
            </a>
        </div>
    </div>
</div>

</x-app-layout>
