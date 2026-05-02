<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Ký túc xá Đại học Phương Đông — Không gian nội trú an toàn, hiện đại dành cho sinh viên. Đăng ký online, nhận phòng nhanh chóng.">

    <title>{{ $title ?? 'Ký túc xá Đại học Phương Đông' }}</title>

    <!-- Preconnect & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom sleek fonts, avoiding Inter if requested, using Quicksand or standard sans for structure */
        body { font-family: 'Quicksand', sans-serif; }
        .font-display { font-family: 'Quicksand', sans-serif; }
    </style>
</head>
<body class="bg-[#fafafa] text-gray-900 antialiased selection:bg-[#10b981] selection:text-white relative min-h-screen flex flex-col">

    <!-- Navigation (Solid Minimal) -->
    <header id="site-header" class="fixed top-0 w-full z-[100] bg-white border-b border-ui-border shadow-sm">
        <div class="max-w-[1200px] mx-auto px-6">
            <nav class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group" aria-label="Trang chủ KTX Phương Đông">
                    <div class="w-8 h-8 rounded-lg bg-black flex items-center justify-center transition-transform duration-300 group-hover:scale-105">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="font-bold text-[15px] tracking-tight text-gray-900 group-hover:text-[#10b981] transition-colors duration-200">KTX Phương Đông</span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden items-center gap-8 text-[14px] font-medium text-gray-600 lg:flex">
                    <a href="/#tong-quan" class="hover:text-black transition-colors duration-200">Tổng quan</a>
                    <a href="{{ route('public.danhsachphong') }}" class="transition-colors duration-200 {{ request()->routeIs('public.danhsachphong') ? 'text-black font-bold' : 'hover:text-black' }}">Phòng nội trú</a>
                    <a href="/#chi-phi" class="hover:text-black transition-colors duration-200">Chi phí</a>
                    <a href="{{ route('guest.lookup') }}" class="hover:text-black transition-colors duration-200">Tra cứu đơn</a>
                    <a href="/#lien-he" class="hover:text-black transition-colors duration-200">Hỗ trợ</a>
                </div>

                <!-- CTA -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dieuhuong') }}" class="hidden sm:inline-flex text-[14px] font-medium text-gray-600 hover:text-black transition-colors duration-200">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-900 px-5 py-2.5 rounded-lg text-[13px] font-bold transition-all duration-200">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex text-[14px] font-medium text-gray-600 hover:text-black transition-colors duration-200">Đăng nhập</a>
                        <a href="{{ route('public.danhsachphong') }}" class="bg-[#10b981] hover:bg-[#059669] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold tracking-wide transition-all duration-200 shadow-sm hover:shadow-md">
                            Đăng ký ngay
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main class="relative z-10 flex-grow">
        {{ $slot }}
    </main>

    <!-- Minimal, structured footer -->
    <footer class="bg-white border-t border-gray-200 pt-24 pb-12 mt-0 relative z-20">
        <div class="max-w-[1280px] mx-auto px-6 grid grid-cols-1 md:grid-cols-12 gap-16 items-start">
            <div class="md:col-span-4 flex flex-col gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-black flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="font-bold text-[15px] tracking-tight text-gray-900">KTX Phương Đông</span>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed max-w-[280px]">Môi trường nội trú hiện đại, an toàn và minh bạch dành riêng cho sinh viên Đại học Phương Đông.</p>
            </div>

            <div class="md:col-span-2 md:col-start-7 flex flex-col gap-5">
                <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400">Kết nối</h4>
                <div class="flex flex-col gap-3 text-sm font-medium text-gray-600">
                    <a href="#" class="hover:text-black transition-colors duration-200">Facebook</a>
                    <a href="#" class="hover:text-black transition-colors duration-200">Zalo OA</a>
                    <a href="#" class="hover:text-black transition-colors duration-200">Email</a>
                </div>
            </div>

            <div class="md:col-span-3 flex flex-col gap-5">
                <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400">Pháp lý</h4>
                <div class="flex flex-col gap-3 text-sm font-medium text-gray-600">
                    <a href="#" class="hover:text-black transition-colors duration-200">Quy định nội trú</a>
                    <a href="#" class="hover:text-black transition-colors duration-200">Chính sách bảo mật</a>
                    <a href="#" class="hover:text-black transition-colors duration-200">Điều khoản dịch vụ</a>
                </div>
            </div>
        </div>
        
        <div class="max-w-[1280px] mx-auto px-6 mt-20 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 font-medium">
            <span>&copy; {{ date('Y') }} Đại học Phương Đông. All rights reserved.</span>
            <span class="mt-2 sm:mt-0 flex items-center gap-1">Designed with <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg> in Hanoi.</span>
        </div>
    </footer>
    <x-toast />
</body>
</html>