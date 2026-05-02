<x-landing-layout>
    <x-slot:title>Đăng ký cư trú KTX</x-slot:title>

    <div class="pt-36 pb-24 min-h-screen bg-[#fafafa] relative overflow-hidden">
        <!-- Minimal Dot Grid -->
        <div class="absolute inset-0 opacity-100 bg-[radial-gradient(#d1d5db_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>
        
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            
            {{-- Minimal Stepper --}}
            <nav class="mb-16">
                <div class="relative mx-auto max-w-xl">
                    <div class="absolute left-0 top-4 h-[1px] w-full bg-ui-border" aria-hidden="true">
                        <div class="absolute h-full w-[50%] bg-ink-primary"></div>
                    </div>
                    
                    <ul class="relative flex justify-between">
                        <li class="flex flex-col items-center">
                            <div class="flex h-8 w-8 items-center justify-center bg-ink-primary text-white border border-ink-primary">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="mt-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Bước 1</span>
                            <span class="mt-1 text-xs font-bold text-ink-primary">Chọn phòng</span>
                        </li>
                        <li class="flex flex-col items-center">
                            <div class="flex h-8 w-8 items-center justify-center bg-ink-primary text-white border border-ink-primary ring-4 ring-ui-border/50">
                                <span class="text-sm font-display font-bold">2</span>
                            </div>
                            <span class="mt-3 text-[10px] font-bold uppercase tracking-widest text-ink-primary">Bước 2</span>
                            <span class="mt-1 text-xs font-bold text-ink-primary">Thông tin cá nhân</span>
                        </li>
                        <li class="flex flex-col items-center">
                            <div class="flex h-8 w-8 items-center justify-center bg-white text-ink-secondary border border-ui-border">
                                <span class="text-sm font-display font-bold">3</span>
                            </div>
                            <span class="mt-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Bước 3</span>
                            <span class="mt-1 text-xs font-bold text-ink-secondary">Hoàn tất</span>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="grid gap-12 lg:grid-cols-12">
                {{-- Form Column --}}
                <div class="lg:col-span-7">
                    <section class="bg-white border border-ui-border p-8 lg:p-10 shadow-sm">
                        <header class="mb-10 border-b border-ui-border pb-6">
                            <h1 class="text-3xl font-display font-bold text-ink-primary tracking-tight mb-2">Thông tin đăng ký.</h1>
                            <p class="text-sm text-ink-secondary leading-relaxed">Vui lòng cung cấp chính xác các thông tin cá nhân và tài liệu cần thiết để khởi tạo hồ sơ cư trú của bạn.</p>
                        </header>
                        
                        <form action="{{ route('guest.dangky.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                            @csrf
                            <input type="hidden" name="phong_id" value="{{ $phong->id }}">
                            
                            @if($giuong_no)
                                <input type="hidden" name="giuong_no" value="{{ $giuong_no }}">
                            @else
                                <div class="bg-ui-bg border border-ui-border p-6">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary block mb-3">Lựa chọn giường cư trú</label>
                                    <div class="relative">
                                        <select name="giuong_no" required class="w-full bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors cursor-pointer @error('giuong_no') border-red-500 @enderror">
                                            <option value="">-- Chọn vị trí giường --</option>
                                            @for($i = 1; $i <= $phong->succhuamax; $i++)
                                                <option value="{{ $i }}">Giường số {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('giuong_no') <p class="mt-2 text-[10px] font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <p class="mt-3 text-[10px] font-medium text-ink-secondary flex items-center gap-1.5">
                                        <span class="text-ink-primary">ℹ</span> Vui lòng chọn giường để tiếp tục quá trình đăng ký.
                                    </p>
                                </div>
                            @endif

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-2 block">Họ và tên</label>
                                    <input type="text" name="ho_ten" required value="{{ old('ho_ten') }}"
                                           class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors" placeholder="NGUYEN VAN A">
                                    @error('ho_ten') <p class="mt-2 text-[10px] font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-2 block">Số CCCD / Định danh</label>
                                    <input type="text" name="so_cccd" required value="{{ old('so_cccd') }}"
                                           class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors" placeholder="012345678912">
                                    @error('so_cccd') <p class="mt-2 text-[10px] font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-2 block">Địa chỉ Email</label>
                                    <input type="email" name="email" required value="{{ old('email') }}"
                                           class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors" placeholder="example@email.com">
                                    @error('email') <p class="mt-2 text-[10px] font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-2 block">Số điện thoại</label>
                                    <input type="text" name="so_dien_thoai" required value="{{ old('so_dien_thoai') }}"
                                           class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors" placeholder="0912345678">
                                    @error('so_dien_thoai') <p class="mt-2 text-[10px] font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="pt-4 border-t border-ui-border">
                                <div class="bg-ui-bg border border-ui-border p-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-2">
                                        <h3 class="text-sm font-bold text-ink-primary uppercase tracking-wide">Tài liệu đính kèm</h3>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary bg-white px-2 py-1 border border-ui-border">JPG, PNG</span>
                                    </div>
                                    <div class="grid gap-6 sm:grid-cols-2">
                                        <div class="space-y-3">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] font-bold uppercase tracking-widest text-ink-primary">Ảnh thẻ (3x4)</span>
                                            </div>
                                            <div class="relative">
                                                <input type="file" name="anh_the" class="block w-full text-xs text-ink-secondary file:mr-3 file:py-2 file:px-4 file:border-0 file:border-r file:border-ui-border file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-white file:text-ink-primary hover:file:bg-ui-bg transition-colors cursor-pointer border border-ui-border bg-white">
                                                @error('anh_the') <p class="mt-2 text-[10px] font-bold text-red-500">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] font-bold uppercase tracking-widest text-ink-primary">Mặt trước CCCD</span>
                                            </div>
                                            <div class="relative">
                                                <input type="file" name="anh_cccd" class="block w-full text-xs text-ink-secondary file:mr-3 file:py-2 file:px-4 file:border-0 file:border-r file:border-ui-border file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-white file:text-ink-primary hover:file:bg-ui-bg transition-colors cursor-pointer border border-ui-border bg-white">
                                                @error('anh_cccd') <p class="mt-2 text-[10px] font-bold text-red-500">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full bg-ink-primary text-white hover:bg-brand-emerald py-4 text-sm font-bold tracking-wide transition-colors uppercase">
                                    Gửi đơn đăng ký lưu trú
                                </button>
                                <div class="mt-4 flex items-start gap-3 p-4 border border-ui-border bg-white">
                                    <span class="text-ink-primary mt-0.5">ℹ</span>
                                    <p class="text-[11px] text-ink-secondary leading-relaxed">
                                        Bằng cách hoàn tất thủ tục này, bạn xác nhận rằng các thông tin cung cấp là hoàn toàn chính xác và đồng ý tuân thủ Nội quy của Ký túc xá.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                {{-- Summary Column --}}
                <div class="lg:col-span-5">
                    <aside class="sticky top-28 space-y-6">
                        <div class="bg-white border border-ui-border overflow-hidden shadow-sm">
                            <div class="bg-ink-primary p-6 md:p-8 text-white border-b border-ink-primary">
                                <h2 class="text-[10px] font-bold uppercase tracking-widest text-white/70 mb-2">Chi tiết đặt chỗ</h2>
                                <div class="flex items-end justify-between">
                                    <h3 class="text-2xl font-display font-bold tracking-tight">Phòng {{ $phong->tenphong }}</h3>
                                    <span class="mb-1 text-[10px] font-bold uppercase tracking-widest text-white/50 border border-white/20 px-2 py-0.5">ID: #{{ $phong->id }}</span>
                                </div>
                            </div>
                            
                            <div class="p-6 md:p-8 space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 flex items-center justify-center bg-ui-bg border border-ui-border text-ink-primary">
                                        <span class="text-sm opacity-50">📍</span>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Vị trí đơn vị</div>
                                        <div class="text-sm font-bold text-ink-primary mt-0.5">Tòa {{ strtoupper(substr($phong->tenphong, 0, 1)) }} — Tầng {{ $phong->tang }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 flex items-center justify-center bg-ui-bg border border-ui-border text-ink-primary">
                                        <span class="text-sm opacity-50">👤</span>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Phân loại giới tính</div>
                                        <div class="text-sm font-bold text-ink-primary mt-0.5">{{ $phong->gioitinh }}</div>
                                    </div>
                                </div>

                                <div class="h-px bg-ui-border"></div>

                                <div class="flex items-center justify-between py-2">
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Vị trí giường</div>
                                        <div class="mt-1 text-sm font-bold text-ink-primary">Số {{ $giuong_no ?? 'Chưa xác định' }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Đơn giá tháng</div>
                                        <div class="mt-1 text-xl font-display font-bold text-brand-emerald">{{ number_format($phong->giaphong, 0, ',', '.') }}đ</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-ui-border p-5 flex gap-4">
                            <div class="h-8 w-8 shrink-0 flex items-center justify-center bg-brand-emerald text-white">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-ink-primary uppercase tracking-widest mb-1">Cơ chế Soft Lock</h4>
                                <p class="text-[11px] text-ink-secondary leading-relaxed">Vị trí giường này sẽ được tạm giữ cho bạn trong 24 giờ kể từ khi gửi đơn. Vui lòng hoàn tất thủ tục xét duyệt sớm.</p>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('public.danhsachphong') }}" class="inline-flex items-center gap-2 py-2 text-[11px] font-bold uppercase tracking-widest text-ink-secondary transition-colors hover:text-ink-primary border-b border-transparent hover:border-ink-primary pb-0.5">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Quay lại chọn phòng khác
                            </a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
