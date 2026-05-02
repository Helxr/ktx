<x-landing-layout>
    <x-slot:title>Ký túc xá Đại học Phương Đông - Không gian sống lý tưởng</x-slot:title>

    <div class="relative z-10 bg-[#fafafa]">
    @if(session('success'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-6">
            <div class="bg-black text-white px-5 py-3.5 rounded-xl shadow-lg border border-gray-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#10b981]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-medium text-[13px] tracking-wide">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-white transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-6">
            <div class="bg-white text-gray-900 px-5 py-4 rounded-xl shadow-lg border border-red-200">
                <div class="flex items-center justify-between mb-2 border-b border-gray-100 pb-2">
                    <span class="font-bold text-[13px] text-red-600 flex items-center gap-2"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Lỗi đăng ký</span>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-900"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <ul class="text-[13px] list-none space-y-1 mt-3 text-gray-600">@foreach ($errors->all() as $error)<li class="flex items-start gap-2"><span class="text-red-400 mt-1">•</span> {{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- ═══ HERO MINIMAL ═══ --}}
    <section id="hero" class="relative pt-32 pb-24 lg:pt-48 lg:pb-32 overflow-hidden border-b border-gray-200 bg-[#fafafa]">
        <!-- Minimal Dot Grid - Enhanced for Hero -->
        <div class="absolute inset-0 opacity-100 bg-[radial-gradient(#d1d5db_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>

        <div class="max-w-[1280px] mx-auto px-6 relative z-10 w-full">
            <div class="max-w-[800px] mx-auto text-center flex flex-col items-center">
                
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-[11px] font-bold uppercase tracking-widest text-gray-500 mb-8 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981] animate-pulse"></span>
                    Năm học 2026–2027
                </div>
                
                <h1 class="font-display text-[clamp(3.5rem,8vw,6rem)] font-bold tracking-tighter text-gray-900 leading-[1.05] mb-6">
                    Sống hiện đại.<br>
                    <span class="text-gray-400">Học hiệu quả.</span>
                </h1>
                
                <p class="text-[clamp(1rem,2vw,1.25rem)] text-gray-600 max-w-[60ch] leading-relaxed mb-10 font-medium">
                    Ký túc xá Đại học Phương Đông mang đến không gian lưu trú an toàn, tiện nghi và minh bạch. Bệ phóng cho những năm tháng đại học rực rỡ nhất của bạn.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                    @auth
                        <a href="{{ route('dieuhuong') }}" class="w-full sm:w-auto bg-black text-white px-8 py-4 rounded-xl text-[14px] font-bold tracking-wide transition-all duration-200 hover:bg-gray-800 hover:-translate-y-0.5 flex items-center justify-center gap-2 shadow-lg shadow-black/10">
                            Đi đến Dashboard
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('public.danhsachphong') }}" class="w-full sm:w-auto bg-black text-white px-8 py-4 rounded-xl text-[14px] font-bold tracking-wide transition-all duration-200 hover:bg-gray-800 hover:-translate-y-0.5 flex items-center justify-center gap-2 shadow-lg shadow-black/10">
                            Đăng ký giữ chỗ
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="#phong-o" class="w-full sm:w-auto bg-white hover:bg-gray-50 text-gray-900 border border-gray-200 px-8 py-4 rounded-xl text-[14px] font-bold tracking-wide transition-all duration-200 shadow-sm hover:-translate-y-0.5 flex items-center justify-center">
                            Xem phòng trống
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Crisp Stats --}}
            <div class="mt-24 max-w-[1000px] mx-auto relative z-20 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-gray-100">
                    <div class="p-8 flex flex-col items-center text-center group">
                        <span class="font-display text-4xl font-bold text-gray-900 mb-1 tracking-tight">{{ $sinhVienDangO }}</span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Sinh viên</span>
                    </div>
                    <div class="p-8 flex flex-col items-center text-center group">
                        <span class="font-display text-4xl font-bold text-gray-900 mb-1 tracking-tight">{{ $tongPhong }}</span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Phòng ở</span>
                    </div>
                    <div class="p-8 flex flex-col items-center text-center group">
                        <span class="font-display text-4xl font-bold text-gray-900 mb-1 tracking-tight">{{ $soTang }}</span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Tầng lầu</span>
                    </div>
                    <div class="p-8 flex flex-col items-center text-center group bg-gray-50/50">
                        <span class="font-display text-4xl font-bold text-[#10b981] mb-1 tracking-tight">4.9<span class="text-2xl text-gray-300">/5</span></span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Đánh giá</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ OVERVIEW (Crisp Bento Grid) ═══ --}}
    <section id="tong-quan" class="py-24 lg:py-32 bg-white relative">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16 lg:gap-24 items-center">
                <div class="flex-1 relative z-10">
                    <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-bold tracking-tighter text-gray-900 mb-6 leading-[1.1]">
                        Hơn cả một nơi để ở.<br>
                        <span class="text-gray-400">Đó là một cộng đồng.</span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-12 max-w-[55ch] leading-relaxed">
                        Được xây dựng theo tiêu chuẩn hiện đại, KTX Phương Đông hướng tới môi trường sống chất lượng cao. Nơi sự riêng tư được tôn trọng và cộng đồng được kết nối.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-4 p-6 rounded-2xl bg-[#fafafa] border border-gray-100 hover:border-gray-200 transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-black text-white flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-base mb-1">Không gian Xanh</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Mảng xanh phân bổ tinh tế khắp hành lang và sân thượng.</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 p-6 rounded-2xl bg-[#fafafa] border border-gray-100 hover:border-gray-200 transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-black text-white flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-base mb-1">An ninh 24/7</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Camera giám sát AI, bảo vệ trực ban và thẻ từ đa lớp.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex-1 w-full">
                    <!-- Clean Bento Grid -->
                    <div class="grid grid-cols-2 gap-4 auto-rows-[160px]">
                        <div class="col-span-2 row-span-2 rounded-2xl overflow-hidden bg-gray-100 relative group border border-gray-200/50 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1568667256549-094345857637?auto=format&fit=crop&w=800&q=80" alt="Thư viện" class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute bottom-6 left-6 z-20 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                                <span class="bg-white/90 backdrop-blur-md text-gray-900 px-4 py-2 rounded-lg text-sm font-bold shadow-sm">Thư viện tự học</span>
                            </div>
                        </div>
                        <div class="rounded-2xl overflow-hidden bg-gray-100 relative group border border-gray-200/50 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1540569014015-19a7be504e3a?auto=format&fit=crop&w=400&q=80" alt="Gym" class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105">
                        </div>
                        <div class="rounded-2xl overflow-hidden bg-gray-100 relative group border border-gray-200/50 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=400&q=80" alt="Căng tin" class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ ROOM LISTING MINIMAL ═══ --}}
    <section id="phong-o" class="py-24 lg:py-32 bg-white relative border-y border-ui-border">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-emerald mb-3">Danh sách phòng</p>
                    <h2 class="font-display text-[clamp(2.5rem,4vw,3.5rem)] font-bold text-ink-primary tracking-tight leading-[1.1]">Tra cứu phòng ở.</h2>
                    <p class="mt-4 text-ink-secondary text-lg">Tình trạng phòng được cập nhật theo thời gian thực từ hệ thống.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <select id="filter-gender" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary block w-full sm:w-[180px] p-3 transition-colors cursor-pointer shadow-sm">
                        <option value="all">Tất cả giới tính</option>
                        <option value="Nam">Phòng Nam</option>
                        <option value="Nữ">Phòng Nữ</option>
                    </select>
                    <select id="filter-status" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary block w-full sm:w-[200px] p-3 transition-colors cursor-pointer shadow-sm">
                        <option value="all">Tất cả trạng thái</option>
                        <option value="available">Còn trống</option>
                        <option value="full">Đã kín chỗ</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4" id="room-container">
                @forelse($phongList as $phong)
                    @php
                        $conTrong = $phong->succhuamax - $phong->dango;
                        $isAvailable = $conTrong > 0;
                        $percentage = ($phong->dango / $phong->succhuamax) * 100;
                    @endphp
                    <div class="room-card bg-white p-5 border border-ui-border hover:border-ink-primary transition-colors duration-300 flex flex-col group shadow-sm hover:shadow-md" data-gender="{{ $phong->gioitinh }}" data-available="{{ $isAvailable ? 'available' : 'full' }}" style="display:none;">
                        
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h3 class="text-base font-display font-bold text-ink-primary mb-0.5">{{ $phong->tenphong }}</h3>
                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-wider">Tầng {{ $phong->tang }} · {{ $phong->gioitinh }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border {{ $isAvailable ? 'border-brand-emerald text-brand-emerald bg-brand-emerald/5' : 'border-red-500 text-red-600 bg-red-500/5' }}">
                                {{ $isAvailable ? 'Còn '.$conTrong : 'Kín chỗ' }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-display font-bold text-ink-primary tracking-tight">{{ number_format($phong->giaphong, 0, ',', '.') }}</span>
                                <span class="text-xs font-bold text-ink-secondary">đ/tháng</span>
                            </div>
                        </div>

                        <div class="space-y-5 flex-grow">
                            <!-- Progress Bar Minimal -->
                            <div>
                                <div class="flex justify-between text-[10px] font-bold text-ink-secondary mb-1.5">
                                    <span>Sức chứa: {{ $phong->succhuamax }}</span>
                                    <span class="{{ $isAvailable ? 'text-ink-primary' : 'text-red-500' }}">Đang ở: {{ $phong->dango }}</span>
                                </div>
                                <div class="w-full bg-ui-bg h-1 rounded-full overflow-hidden">
                                     
                                     <div class="h-full rounded-full transition-all duration-500 ease-out {{ $isAvailable ? 'bg-brand-emerald' : 'bg-red-500' }}" style="--w: {{ (int)$percentage }}%; width: var(--w);"></div>
                                 </div>
                            </div>
                            
                            <!-- Features -->
                            <div class="flex flex-wrap gap-1.5">
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-ui-bg text-ink-primary text-[10px] font-medium border border-ui-border"><span class="text-[10px] opacity-50">❄️</span> Máy lạnh</span>
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-ui-bg text-ink-primary text-[10px] font-medium border border-ui-border"><span class="text-[10px] opacity-50">🛏️</span> Giường tầng</span>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-ui-border">
                            @if($isAvailable)
                                <a href="{{ route('guest.dangky.create', ['phong_id' => $phong->id]) }}" class="w-full bg-ink-primary text-white hover:bg-brand-emerald py-2.5 text-[11px] font-bold tracking-wide transition-colors flex items-center justify-center gap-2 group-hover:gap-3">
                                    Đăng ký <span class="transition-all">→</span>
                                </a>
                            @else
                                <button disabled class="w-full bg-ui-bg text-ink-secondary py-2.5 text-[11px] font-bold tracking-wide cursor-not-allowed border border-ui-border">
                                    Đã kín chỗ
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-24 bg-ui-bg border border-ui-border">
                        <h3 class="text-xl font-bold text-ink-primary mb-2">Chưa có dữ liệu phòng</h3>
                        <p class="text-sm text-ink-secondary max-w-md mx-auto">Hệ thống đang được cập nhật dữ liệu từ Ban quản lý.</p>
                    </div>
                @endforelse
            </div>
            
            <div id="pagination-controls" class="mt-16 flex justify-center gap-2"></div>
        </div>
    </section>
    {{-- ═══ PRICING MINIMAL ═══ --}}
    <section id="chi-phi" class="py-24 lg:py-32 relative bg-ui-bg border-b border-ui-border">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <p class="text-brand-emerald font-bold tracking-widest uppercase text-xs mb-3">Minh bạch & Rõ ràng</p>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-ink-primary tracking-tight">Chi phí sinh hoạt.</h2>
                <p class="mt-4 text-ink-secondary text-lg">Mọi khoản phí đều được niêm yết công khai theo quy định của Đại học Phương Đông.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Bảng giá dịch vụ -->
                <div class="bg-white border border-ui-border p-8 md:p-10 transition-colors duration-300 hover:border-ink-primary group">
                    <h3 class="text-2xl font-display font-bold text-ink-primary mb-8">Bảng giá dịch vụ</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-4 bg-ui-bg border border-ui-border group-hover:border-ink-primary/20 transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="text-lg opacity-80">⚡</span>
                                <span class="font-bold text-ink-primary">Giá điện</span>
                            </div>
                            <span class="font-bold text-ink-primary text-lg">{{ isset($cauhinh['gia_dien']) ? number_format($cauhinh['gia_dien'], 0, ',', '.') : '3.500' }}đ<span class="text-sm text-ink-secondary font-medium">/kWh</span></span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-ui-bg border border-ui-border group-hover:border-ink-primary/20 transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="text-lg opacity-80">💧</span>
                                <span class="font-bold text-ink-primary">Nước sinh hoạt</span>
                            </div>
                            <span class="font-bold text-ink-primary text-lg">{{ isset($cauhinh['gia_nuoc']) ? number_format($cauhinh['gia_nuoc'], 0, ',', '.') : '15.000' }}đ<span class="text-sm text-ink-secondary font-medium">/m³</span></span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-brand-emerald/5 border border-brand-emerald/20">
                            <div class="flex items-center gap-4">
                                <span class="text-lg opacity-80">🌐</span>
                                <span class="font-bold text-brand-emerald">Internet / WiFi</span>
                            </div>
                            <span class="font-bold text-brand-emerald text-sm uppercase tracking-wider">Miễn phí</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-brand-emerald/5 border border-brand-emerald/20">
                            <div class="flex items-center gap-4">
                                <span class="text-lg opacity-80">🧹</span>
                                <span class="font-bold text-brand-emerald">Vệ sinh hành lang</span>
                            </div>
                            <span class="font-bold text-brand-emerald text-sm uppercase tracking-wider">Miễn phí</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-ui-bg border border-ui-border group-hover:border-ink-primary/20 transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="text-lg opacity-80">🛵</span>
                                <span class="font-bold text-ink-primary">Gửi xe máy</span>
                            </div>
                            <span class="font-bold text-ink-primary text-lg">120.000đ<span class="text-sm text-ink-secondary font-medium">/tháng</span></span>
                        </div>
                    </div>
                </div>
                
                <!-- Nội quy cơ bản -->
                <div class="bg-ink-primary text-white border border-ink-primary p-8 md:p-10">
                    <h3 class="text-2xl font-display font-bold text-white mb-8">Nội quy cơ bản</h3>
                    <ul class="space-y-6">
                        <li class="flex gap-4">
                            <div class="w-8 h-8 flex items-center justify-center shrink-0 border border-white/20">
                                <svg class="w-4 h-4 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <strong class="block text-white mb-1">Giờ giới nghiêm</strong>
                                <span class="text-white/70 text-sm leading-relaxed">Đóng cửa KTX vào lúc 23:00 và mở cửa vào 05:00 sáng hôm sau.</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 flex items-center justify-center shrink-0 border border-white/20">
                                <svg class="w-4 h-4 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <strong class="block text-white mb-1">Khách đến thăm</strong>
                                <span class="text-white/70 text-sm leading-relaxed">Đăng ký tại phòng bảo vệ. Thời gian từ 08:00 – 21:00. Không ở lại qua đêm.</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 flex items-center justify-center shrink-0 border border-white/20">
                                <svg class="w-4 h-4 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <strong class="block text-white mb-1">Thiết bị điện</strong>
                                <span class="text-white/70 text-sm leading-relaxed">Nghiêm cấm sử dụng bếp gas, bếp từ cá nhân và các thiết bị công suất lớn trong phòng.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ TESTIMONIALS MINIMAL ═══ --}}
    <section class="py-24 lg:py-32 bg-white relative border-b border-ui-border">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="text-center max-w-[800px] mx-auto mb-16">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-emerald mb-3">Sinh viên Đại học Phương Đông</p>
                <h2 class="font-display text-[clamp(2.25rem,4vw,3rem)] font-bold text-ink-primary tracking-tight">Hơn 500+ sinh viên đã coi đây là ngôi nhà thứ hai.</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['name'=>'Nguyễn Mai Phương','school'=>'SV năm 2 – ĐH Phương Đông','text'=>'Phòng ốc sạch sẽ và thoáng mát. An ninh rất tốt, đi làm thêm về trễ vẫn rất an tâm vì luôn có bảo vệ trực.','img'=>'photo-1438761681033-6461ffad8d80'],
                    ['name'=>'Trần Tuấn Kiệt','school'=>'SV năm 4 – ĐH Phương Đông','text'=>'Đăng ký hoàn toàn online, không rườm rà. Gym và Căng tin rất tiện, không cần ra ngoài KTX.','img'=>'photo-1500648767791-00dcc994a43e'],
                    ['name'=>'Lê Hoàng Lan','school'=>'SV năm 1 – ĐH Phương Đông','text'=>'App quản lý rất xịn. Báo sự cố trên web là hôm sau có người lên sửa ngay. 10 điểm dịch vụ!','img'=>'photo-1494790108377-be9c29b29330'],
                ] as $review)
                <div class="bg-ui-bg p-8 border border-ui-border hover:border-ink-primary transition-colors duration-300 flex flex-col">
                    <div class="flex gap-1 text-ink-primary mb-6 text-sm">★★★★★</div>
                    <p class="text-base text-ink-secondary mb-10 leading-relaxed flex-grow">"{{ $review['text'] }}"</p>
                    <div class="flex items-center gap-4 pt-6 border-t border-ui-border">
                        <div class="w-12 h-12 overflow-hidden bg-ui-border shrink-0 grayscale">
                            <img src="https://images.unsplash.com/{{ $review['img'] }}?auto=format&fit=crop&w=100&q=80" alt="{{ $review['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-ink-primary text-sm">{{ $review['name'] }}</h4>
                            <p class="text-xs font-medium text-brand-emerald mt-0.5">{{ $review['school'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ PROCESS STEPPER MINIMAL ═══ --}}
    <section id="quy-trinh" class="py-24 lg:py-32 bg-ui-bg border-b border-ui-border">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="text-center max-w-[800px] mx-auto mb-20">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-emerald mb-3">100% Online</p>
                <h2 class="font-display text-[clamp(2.25rem,4vw,3rem)] font-bold text-ink-primary tracking-tight">Quy trình đăng ký siêu tốc.</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 text-center max-w-[1100px] mx-auto relative z-10">
                @foreach([
                    ['num'=>1,'title'=>'Tạo tài khoản','desc'=>'Bằng MSSV & Email'],
                    ['num'=>2,'title'=>'Chọn phòng','desc'=>'Xem ảnh & giá thực tế'],
                    ['num'=>3,'title'=>'Nộp hồ sơ','desc'=>'Điền form online','active'=>true],
                    ['num'=>4,'title'=>'Ký hợp đồng','desc'=>'Hợp đồng điện tử'],
                    ['num'=>5,'title'=>'Nhận phòng','desc'=>'Dọn vào ở ngay']
                ] as $step)
                <div class="flex flex-col items-center relative group">
                    <!-- Connector Line (Desktop only) -->
                    @if(!$loop->last)
                        <div class="hidden md:block absolute top-8 left-[60%] w-full h-[1px] bg-ui-border -z-10">
                            <div class="h-full bg-ink-primary w-0 group-hover:w-full transition-all duration-500 ease-out"></div>
                        </div>
                    @endif
                    
                    <div class="w-16 h-16 flex items-center justify-center text-xl font-display font-bold mb-6 transition-colors duration-300 border {{ isset($step['active']) ? 'bg-ink-primary text-white border-ink-primary' : 'bg-white text-ink-primary border-ui-border group-hover:border-ink-primary' }}">
                        {{ $step['num'] }}
                    </div>
                    <h3 class="text-base font-bold text-ink-primary mb-1">{{ $step['title'] }}</h3>
                    <p class="text-xs font-medium text-ink-secondary">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-20 text-center">
                <a href="#phong-o" class="inline-flex items-center justify-center gap-3 bg-ink-primary hover:bg-brand-emerald text-white px-8 py-4 text-sm font-bold tracking-wide transition-colors group">
                    Bắt đầu chọn phòng ngay <span class="transition-transform group-hover:translate-x-1">→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══ CONTACT MINIMAL ═══ --}}
    <section id="lien-he" class="py-24 lg:py-32 bg-white relative">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                <div class="lg:col-span-5 flex flex-col justify-center">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-emerald mb-3">Liên hệ</p>
                    <h2 class="font-display text-[clamp(2.25rem,4vw,3rem)] font-bold mb-6 text-ink-primary leading-tight">Hỗ trợ sinh viên 24/7.</h2>
                    <p class="text-ink-secondary text-lg mb-12 leading-relaxed max-w-[400px]">Ban quản lý KTX Đại học Phương Đông luôn sẵn sàng giải đáp mọi thắc mắc về thủ tục, chi phí và cuộc sống tại KTX.</p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 flex items-center justify-center shrink-0 border border-ui-border text-ink-primary">📍</div>
                            <div>
                                <h4 class="font-bold text-sm mb-1 text-ink-primary uppercase tracking-wide">Văn phòng BQL</h4>
                                <p class="text-sm text-ink-secondary leading-relaxed">Phòng 101, Tầng trệt, Tòa nhà KTX<br>Số 4, Ngõ 228 Minh Khai, Q.Hai Bà Trưng, HN</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 flex items-center justify-center shrink-0 border border-ui-border text-ink-primary">📞</div>
                            <div>
                                <h4 class="font-bold text-sm mb-1 text-ink-primary uppercase tracking-wide">Hotline (Zalo)</h4>
                                <p class="text-sm text-ink-secondary leading-relaxed">{{ $cauhinh['hotline'] ?? '024 3624 1394' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 flex items-center justify-center shrink-0 border border-ui-border text-ink-primary">✉️</div>
                            <div>
                                <h4 class="font-bold text-sm mb-1 text-ink-primary uppercase tracking-wide">Email hỗ trợ</h4>
                                <p class="text-sm text-ink-secondary leading-relaxed">ktx@phuongdong.edu.vn</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="bg-ui-bg p-8 sm:p-12 border border-ui-border">
                        <h3 class="text-2xl font-display font-bold text-ink-primary mb-8">Gửi yêu cầu hỗ trợ</h3>
                        
                        <form action="{{ route('landing.lienhe') }}" method="POST" class="space-y-6">
                            @csrf
                            @if(session('lienhe_thanhcong'))
                                <div class="bg-brand-emerald/10 border border-brand-emerald px-6 py-4 flex items-center gap-3">
                                    <span class="text-brand-emerald text-xl">✓</span>
                                    <p class="text-sm font-bold text-brand-emerald">{{ session('lienhe_thanhcong') }}</p>
                                </div>
                            @endif
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-ink-secondary mb-2">Họ và tên</label>
                                    <input type="text" name="ho_ten" value="{{ old('ho_ten') }}" class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3.5 transition-colors" placeholder="Nguyễn Văn A">
                                    @error('ho_ten')<p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-ink-secondary mb-2">Email hoặc SĐT</label>
                                    <input type="text" name="email" value="{{ old('email') }}" class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3.5 transition-colors" placeholder="lienhe@phuongdong.edu.vn">
                                    @error('email')<p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-ink-secondary mb-2">Nội dung cần hỗ trợ</label>
                                <textarea rows="4" name="noi_dung" class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3.5 transition-colors resize-none" placeholder="Bạn cần Ban quản lý hỗ trợ vấn đề gì?">{{ old('noi_dung') }}</textarea>
                                @error('noi_dung')<p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                            </div>
                            
                            <button type="submit" class="w-full bg-ink-primary text-white py-4 text-sm font-bold tracking-wide transition-colors hover:bg-brand-emerald">
                                Gửi yêu cầu ngay
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer rendered by layout --}}

    {{-- Chatbot Minimal --}}
    <div class="fixed bottom-8 right-8 z-50">
        <button id="chat-toggle" type="button" class="flex h-14 w-14 items-center justify-center bg-ink-primary text-white transition-colors hover:bg-brand-emerald group shadow-sm border border-ui-border" aria-label="Mở chat hỗ trợ">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                <span class="relative inline-flex h-3 w-3 bg-brand-emerald border border-white"></span>
            </span>
        </button>
        <div id="chat-box" class="absolute bottom-16 right-0 w-[320px] origin-bottom-right scale-0 opacity-0 transition-all duration-200 ease-out border border-ui-border bg-white shadow-xl">
            <div class="bg-ink-primary px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 flex items-center justify-center">
                        <span class="text-sm">💬</span>
                    </div>
                    <div>
                        <span class="font-bold text-white text-sm block">Trợ lý KTX</span>
                        <span class="text-[10px] text-white/60 uppercase tracking-wider">Đang trực tuyến</span>
                    </div>
                </div>
            </div>
            <div class="p-5 h-64 bg-ui-bg flex flex-col justify-end gap-3 overflow-y-auto">
                <div class="bg-white border border-ui-border p-3 text-sm text-ink-primary self-start max-w-[85%] leading-relaxed">
                    Xin chào 👋<br>Bạn cần hỗ trợ vấn đề gì?
                </div>
                <div class="flex gap-2 self-start max-w-[85%] flex-wrap">
                    <button class="text-xs font-medium border border-ui-border bg-white text-ink-primary px-3 py-1.5 hover:border-ink-primary transition-colors">Bảng giá</button>
                    <button class="text-xs font-medium border border-ui-border bg-white text-ink-primary px-3 py-1.5 hover:border-ink-primary transition-colors">Đăng ký</button>
                </div>
            </div>
            <div class="p-3 bg-white border-t border-ui-border">
                <div class="relative">
                    <input type="text" placeholder="Nhập câu hỏi..." class="w-full bg-ui-bg border border-ui-border py-2.5 pl-3 pr-10 text-sm focus:ring-0 focus:border-ink-primary rounded-none transition-colors">
                    <button class="absolute right-1.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-ink-primary text-white flex items-center justify-center hover:bg-brand-emerald transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chatbot toggle
        const toggle = document.getElementById('chat-toggle');
        const box = document.getElementById('chat-box');
        if (toggle && box) {
            toggle.addEventListener('click', function () {
                const hidden = box.classList.contains('scale-0');
                box.classList.toggle('scale-0', !hidden);
                box.classList.toggle('opacity-0', !hidden);
                box.classList.toggle('scale-100', hidden);
                box.classList.toggle('opacity-100', hidden);
            });
        }

        // Navbar scroll
        const header = document.getElementById('site-header');
        if (header) {
            window.addEventListener('scroll', () => {
                header.classList.toggle('shadow-md', window.scrollY > 20);
                header.classList.toggle('backdrop-blur-xl', window.scrollY > 20);
            });
        }

        // Room Filtering & Pagination
        const filterGender = document.getElementById('filter-gender');
        const filterStatus = document.getElementById('filter-status');
        const roomCards = Array.from(document.querySelectorAll('.room-card'));
        const pagCtrl = document.getElementById('pagination-controls');
        let currentPage = 1, itemsPerPage = 6, filteredCards = [];

        function renderPagination() {
            if (!pagCtrl) return;
            pagCtrl.innerHTML = '';
            const total = Math.ceil(filteredCards.length / itemsPerPage);
            if (total <= 1) return;
            for (let i = 1; i <= total; i++) {
                const btn = document.createElement('button');
                btn.innerText = i;
                btn.className = `w-10 h-10 rounded-xl font-bold text-sm flex items-center justify-center transition-all duration-300 ${i === currentPage ? 'bg-brand-emerald text-white shadow-lg shadow-brand-emerald/30 scale-110' : 'bg-white border border-ui-border text-ink-secondary hover:border-brand-emerald/50 hover:text-brand-emerald'}`;
                btn.onclick = () => { 
                    currentPage = i; 
                    updateDisplay(); 
                    document.getElementById('phong-o').scrollIntoView({behavior:'smooth',block:'start'}); 
                };
                pagCtrl.appendChild(btn);
            }
        }

        function updateDisplay() {
            roomCards.forEach(c => c.style.display = 'none');
            const start = (currentPage - 1) * itemsPerPage;
            filteredCards.slice(start, start + itemsPerPage).forEach(c => {
                c.style.display = 'flex';
                c.style.animation = 'none';
                void c.offsetWidth;
                c.style.animation = 'sweep .5s cubic-bezier(0.16, 1, 0.3, 1) forwards';
            });
            renderPagination();
        }

        function filterRooms() {
            const g = filterGender.value, s = filterStatus.value;
            filteredCards = roomCards.filter(c => (g === 'all' || g === c.dataset.gender) && (s === 'all' || s === c.dataset.available));
            currentPage = 1;
            updateDisplay();
        }

        if (filterGender && filterStatus && roomCards.length > 0) {
            filterGender.addEventListener('change', filterRooms);
            filterStatus.addEventListener('change', filterRooms);
            filterRooms();
        }
    });
    </script>
    </div>
</x-landing-layout>
