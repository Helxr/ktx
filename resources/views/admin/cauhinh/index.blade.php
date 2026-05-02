<x-admin-layout>
    <x-slot:title>Thiết lập thông số vận hành</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Cấu hình hệ thống</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Thiết lập định mức vận hành toàn khu.</p>
        </div>
    </div>

    <article class="max-w-4xl rounded-3xl bg-white border border-ui-border shadow-sm overflow-hidden">
        <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4">
            <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Bảng tham số định mức</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.capnhatcauhinh') }}" class="p-8 space-y-8">
            @csrf
            <div class="grid gap-8 md:grid-cols-2">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-2 ml-1">Đơn giá Điện (kWh)</label>
                        <div class="relative group">
                            <input type="number" min="0" step="0.01" name="gia_dien"
                                   value="{{ old('gia_dien', $cauhinh['gia_dien']->giatri ?? '') }}"
                                   class="linear-input w-full font-bold tabular-nums pr-12" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-ink-secondary/40">VNĐ</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-2 ml-1">Đơn giá Nước (m³)</label>
                        <div class="relative group">
                            <input type="number" min="0" step="0.01" name="gia_nuoc"
                                   value="{{ old('gia_nuoc', $cauhinh['gia_nuoc']->giatri ?? '') }}"
                                   class="linear-input w-full font-bold tabular-nums pr-12" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-ink-secondary/40">VNĐ</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-2 ml-1">Đường dây nóng (Hotline)</label>
                        <div class="relative group">
                            <input type="text" name="hotline"
                                   value="{{ old('hotline', $cauhinh['hotline']->giatri ?? '') }}"
                                   class="linear-input w-full font-bold tabular-nums pl-12" required>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary/40">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1.01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rounded-2xl bg-ui-bg/50 p-6 ring-1 ring-inset ring-ui-border">
                        <div class="flex items-center gap-3 text-ink-secondary">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs font-medium leading-relaxed italic">Các thông số này sẽ được áp dụng trực tiếp khi kết xuất hóa đơn hàng tháng cho toàn bộ phòng trong KTX.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-ui-border">
                <button type="submit" class="rounded-xl bg-ink-primary px-8 py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald active:scale-[0.98]">
                    Lưu tham số vận hành
                </button>
            </div>
        </form>
    </article>
</x-admin-layout>
