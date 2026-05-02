<x-landing-layout>
    <x-slot:title>Danh sách phòng KTX</x-slot:title>

    <section class="pt-36 pb-20 lg:pt-44 lg:pb-28 bg-[#fafafa] relative overflow-hidden min-h-screen">
        <!-- Minimal Dot Grid -->
        <div class="absolute inset-0 opacity-100 bg-[radial-gradient(#d1d5db_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>
        
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="mb-12 border-b border-ui-border pb-8">
                <p class="text-xs font-bold uppercase tracking-widest text-ink-secondary mb-3">Phòng nội trú</p>
                <h1 class="font-display text-4xl sm:text-5xl font-bold tracking-tight text-ink-primary">Chọn phòng phù hợp với bạn.</h1>
                <p class="mt-4 text-ink-secondary max-w-lg text-lg">Tất cả thông tin phòng được cập nhật theo thời gian thực.</p>
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap gap-3 mb-10">
                <select id="filter-gender" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors cursor-pointer w-full sm:w-[180px] shadow-sm">
                    <option value="all">Tất cả giới tính</option>
                    <option value="Nam">Phòng Nam</option>
                    <option value="Nữ">Phòng Nữ</option>
                </select>
                <select id="filter-status" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors cursor-pointer w-full sm:w-[200px] shadow-sm">
                    <option value="all">Tất cả trạng thái</option>
                    <option value="available">Còn trống</option>
                    <option value="full">Đã kín chỗ</option>
                </select>
            </div>

            {{-- Room Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5" id="room-container">
                @forelse($danhsachphong as $phong)
                    @php
                        $conTrong = $phong->succhuamax - $phong->dango;
                        $isAvailable = $conTrong > 0;
                        $pct = ($phong->dango / $phong->succhuamax) * 100;
                    @endphp
                    <div class="room-card bg-white p-5 border border-ui-border hover:border-ink-primary transition-colors duration-300 flex flex-col group shadow-sm hover:shadow-md"
                         data-gender="{{ $phong->gioitinh }}"
                         data-available="{{ $isAvailable ? 'available' : 'full' }}"
                         style="display:none;">
                        
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
                            <div>
                                <div class="flex justify-between text-[10px] font-bold text-ink-secondary mb-1.5">
                                    <span>Sức chứa: {{ $phong->succhuamax }}</span>
                                    <span class="{{ $isAvailable ? 'text-ink-primary' : 'text-red-500' }}">Đang ở: {{ $phong->dango }}</span>
                                </div>
                                <div class="w-full bg-ui-bg h-1 overflow-hidden">
                                    <div class="h-full transition-all duration-500 ease-out {{ $isAvailable ? 'bg-brand-emerald' : 'bg-red-500' }}" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-ui-bg text-ink-primary text-[10px] font-medium border border-ui-border"><span class="text-[10px] opacity-50">❄️</span> Máy lạnh</span>
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-ui-bg text-ink-primary text-[10px] font-medium border border-ui-border"><span class="text-[10px] opacity-50">🛏️</span> Giường tầng</span>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-ui-border">
                            @if($isAvailable)
                                <a href="{{ route('guest.dangky.create', ['phong_id' => $phong->id]) }}" class="w-full bg-ink-primary text-white hover:bg-brand-emerald py-2.5 text-[11px] font-bold tracking-wide transition-colors flex items-center justify-center gap-2 group-hover:gap-3 uppercase">
                                    Đăng ký <span class="transition-all">→</span>
                                </a>
                            @else
                                <button disabled class="w-full bg-ui-bg text-ink-secondary py-2.5 text-[11px] font-bold tracking-wide cursor-not-allowed border border-ui-border uppercase">
                                    Đã kín chỗ
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white border border-ui-border shadow-sm">
                        <div class="text-3xl mb-4 opacity-50">🏢</div>
                        <h3 class="text-lg font-bold text-ink-primary mb-2 font-display">Chưa có dữ liệu phòng</h3>
                        <p class="text-sm text-ink-secondary">Vui lòng quay lại sau hoặc thử lại với bộ lọc khác.</p>
                    </div>
                @endforelse
            </div>
            <div id="pagination-controls" class="mt-12 flex justify-center gap-2"></div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const fG = document.getElementById('filter-gender'), fS = document.getElementById('filter-status');
        const cards = Array.from(document.querySelectorAll('.room-card')), pagC = document.getElementById('pagination-controls');
        let page = 1, perPage = 9, filtered = [];

        function render() {
            if (!pagC) return; pagC.innerHTML = '';
            const total = Math.ceil(filtered.length / perPage);
            if (total <= 1) return;
            for (let i = 1; i <= total; i++) {
                const b = document.createElement('button'); b.innerText = i;
                b.className = `w-9 h-9 rounded-full font-bold text-sm flex items-center justify-center transition-colors ${i===page?'bg-brand-emerald text-slate-100':'bg-ui-card border border-ui-border text-ink-secondary hover:bg-ui-muted'}`;
                b.onclick = () => { page = i; update(); window.scrollTo({top:0,behavior:'smooth'}); };
                pagC.appendChild(b);
            }
        }
        function update() {
            cards.forEach(c => c.style.display = 'none');
            filtered.slice((page-1)*perPage, page*perPage).forEach(c => { c.style.display='flex'; c.style.animation='none'; void c.offsetWidth; c.style.animation='sweep .35s ease-out forwards'; });
            render();
        }
        function filter() {
            const g = fG.value, s = fS.value;
            filtered = cards.filter(c => (g==='all'||g===c.dataset.gender) && (s==='all'||s===c.dataset.available));
            page = 1; update();
        }
        if (fG && fS && cards.length) { fG.addEventListener('change', filter); fS.addEventListener('change', filter); filter(); }
    });
    </script>
</x-landing-layout>
