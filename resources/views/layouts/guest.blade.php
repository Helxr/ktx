<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'He thong quan ly KTX') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="linear-shell transition-colors duration-300 font-sans antialiased text-slate-800 bg-slate-50">
        <div class="min-h-screen flex">
            <!-- Left Side: Image/Branding (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 items-center justify-center overflow-hidden">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80" alt="KTX Background" class="absolute inset-0 w-full h-full object-cover opacity-50">
                
                <!-- Decorative overlay -->
                <div class="absolute inset-0 bg-slate-900/70"></div>
                
                <div class="relative z-10 max-w-lg px-10">
                    <div class="w-16 h-16 rounded-2xl bg-ui-card/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white font-display font-bold text-3xl mb-8 shadow-xl">
                        K
                    </div>
                    <h2 class="text-4xl font-display font-bold text-white mb-6 leading-tight">Khám phá không gian sống lý tưởng.</h2>
                    <p class="text-lg text-slate-300 leading-relaxed">Hệ thống quản lý Ký túc xá hiện đại. Giúp bạn dễ dàng tra cứu, đăng ký phòng và trải nghiệm môi trường sống tiện nghi nhất trong suốt quãng đời sinh viên.</p>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative bg-slate-50 lg:bg-ui-card">
                <!-- Decorative blobs -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-brand-100 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-sky-100 rounded-full blur-[80px] opacity-60 pointer-events-none"></div>
                
                <div class="relative w-full max-w-md animate-fade-up z-10">
                    <!-- Mobile Logo -->
                    <div class="mb-8 flex justify-center lg:hidden">
                        <div class="w-14 h-14 rounded-2xl bg-brand-600 flex items-center justify-center text-white font-display font-bold text-2xl shadow-lg shadow-brand-500/30">
                            K
                        </div>
                    </div>

                    <div class="bg-ui-card rounded-[2rem] p-8 sm:p-10 shadow-2xl shadow-slate-200/50 border border-slate-100 relative">
                        {{ $slot }}
                    </div>
                    
                    <div class="mt-8 text-center text-xs text-slate-500 lg:hidden">
                        &copy; {{ date('Y') }} KTX ABC. Mọi quyền được bảo lưu.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
