@extends('student.layouts.chinh')

@section('student_page_title', 'Báo hỏng tài sản')

@section('noidung')
    @php
        $total = $danhsachbaohong->count();
        $pending = $danhsachbaohong->whereIn('trangthai', [\App\Enums\MaintenanceStatus::PENDING->value, \App\Enums\MaintenanceStatus::SCHEDULED->value, \App\Enums\MaintenanceStatus::IN_PROGRESS->value])->count();
        $fixed = $danhsachbaohong->where('trangthai', \App\Enums\MaintenanceStatus::COMPLETED->value)->count();
    @endphp

    <div class="mb-6 flex justify-end">
        <button type="button"
                data-modal-target="modal-thembaohong" data-modal-toggle="modal-thembaohong"
                class="pdu-btn-primary flex items-center justify-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Gửi yêu cầu mới
        </button>
    </div>

    {{-- Statistics Bento Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <article class="group relative overflow-hidden rounded-[2rem] border border-ui-border bg-white p-6 shadow-sm transition-all hover:border-brand-emerald/30">
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-slate-100 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-primary ring-1 ring-ui-border">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-widest text-ink-secondary/40 mb-0.5">Tổng số yêu cầu</div>
                    <div class="font-display text-2xl font-black text-ink-primary tabular-nums">{{ $total }}</div>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-[2rem] border border-ui-border bg-white p-6 shadow-sm transition-all hover:border-amber-500/30">
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-amber-500/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 ring-1 ring-amber-500/10">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-widest text-ink-secondary/40 mb-0.5">Đang xử lý</div>
                    <div class="font-display text-2xl font-black text-amber-600 tabular-nums">{{ $pending }}</div>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-[2rem] border border-ui-border bg-white p-6 shadow-sm transition-all hover:border-brand-emerald/30">
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-brand-emerald/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-emerald ring-1 ring-brand-emerald/10">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-widest text-ink-secondary/40 mb-0.5">Đã hoàn thành</div>
                    <div class="font-display text-2xl font-black text-brand-emerald tabular-nums">{{ $fixed }}</div>
                </div>
            </div>
        </article>
    </div>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <article class="overflow-hidden rounded-[2.5rem] border border-ui-border bg-ui-card/30 backdrop-blur-xl shadow-sm transition-all hover:border-brand-emerald/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-primary">
                    <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary">
                        <tr>
                            <th class="px-8 py-6">Nội dung sự cố</th>
                            <th class="px-8 py-6 text-center">Hình ảnh</th>
                            <th class="px-8 py-6 text-center">Tiến độ</th>
                            <th class="px-8 py-6 text-right">Phản hồi của BQL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border/60">
                        @forelse ($danhsachbaohong as $baohong)
                            <tr class="group transition-all hover:bg-white/60">
                                <td class="px-8 py-8">
                                    <div class="max-w-md font-bold text-ink-primary leading-relaxed text-base">{{ $baohong->mota }}</div>
                                    <div class="mt-2 flex items-center gap-3">
                                        <div class="text-[9px] font-black text-ink-secondary/40 uppercase tracking-widest flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-ui-bg border border-ui-border">
                                            #REP-{{ str_pad((string)$baohong->id, 5, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest flex items-center gap-1.5">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ $baohong->created_at->format('d/m/Y') }}
                                        </div>
                                        @if($baohong->phi_boi_thuong > 0)
                                            <div class="text-[9px] font-black text-rose-600 uppercase tracking-widest flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-50 ring-1 ring-rose-500/20">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ number_format($baohong->phi_boi_thuong) }}đ
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-8 text-center">
                                    @if ($baohong->anhminhhoa)
                                        <div class="relative inline-block group/thumb">
                                            <div class="absolute -inset-1 rounded-2xl bg-brand-emerald/20 opacity-0 blur group-hover/thumb:opacity-100 transition-opacity"></div>
                                            <a href="{{ asset($baohong->anhminhhoa) }}" target="_blank" class="relative inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white border border-ui-border p-1 shadow-sm transition-all hover:-translate-y-1">
                                                <img src="{{ asset($baohong->anhminhhoa) }}" class="h-full w-full object-cover rounded-xl" />
                                            </a>
                                        </div>
                                    @else
                                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg/50 text-ink-secondary/10 border border-dashed border-ui-border">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-8 text-center">
                                    @php
                                        $status = $baohong->trangthai;
                                        $badgeClass = match($status) {
                                            \App\Enums\MaintenanceStatus::COMPLETED->value => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                            \App\Enums\MaintenanceStatus::SCHEDULED->value => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10',
                                            \App\Enums\MaintenanceStatus::IN_PROGRESS->value => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                            default => 'bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-600/20'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-4 py-1.5 text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-8 py-8 text-right">
                                    @if($baohong->noidung)
                                        <div class="text-xs font-bold text-ink-primary leading-relaxed bg-brand-emerald/5 border border-brand-emerald/10 rounded-2xl p-4 inline-block max-w-[240px] text-left relative">
                                            <div class="absolute -right-1 top-4 h-2 w-2 rotate-45 bg-brand-emerald/10 border-t border-r border-brand-emerald/20"></div>
                                            {{ $baohong->noidung }}
                                            @if($baohong->ngayhen)
                                                <div class="mt-2 pt-2 border-t border-brand-emerald/10 flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest text-brand-emerald">
                                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    Hẹn: {{ \Carbon\Carbon::parse($baohong->ngayhen)->format('d/m/Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-[10px] font-bold text-ink-secondary/30 italic">Đang chờ phản hồi...</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-32 text-center">
                                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-[2rem] bg-ui-bg text-ink-secondary/20 mb-6 ring-1 ring-ui-border shadow-inner">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <div class="text-lg font-black text-ink-primary uppercase tracking-tight">Cơ sở hạ tầng tối ưu</div>
                                    <p class="text-xs text-ink-secondary mt-1 max-w-sm mx-auto">Hiện tại chưa ghi nhận sự cố nào tại phòng của em. Hãy giữ gìn tài sản chung nhé!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </div>

    {{-- Modal Thêm Báo Hỏng --}}
    <div id="modal-thembaohong" tabindex="-1" aria-hidden="true"
         class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-md animate-in fade-in duration-300">
        <div class="relative w-full max-w-lg animate-in zoom-in-95 duration-500">
            <div class="relative rounded-[3rem] border border-ui-border bg-white p-10 shadow-2xl overflow-hidden group">
                <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-brand-emerald/5 blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                
                <div class="relative mb-10 flex items-start justify-between">
                    <div>
                        <h3 class="font-display text-3xl font-black text-ink-primary uppercase tracking-tighter">Gửi yêu cầu <span class="text-brand-emerald">Hỗ trợ</span></h3>
                        <p class="mt-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/50">Mô tả chi tiết sự cố để được xử lý nhanh nhất</p>
                    </div>
                    <button type="button" class="flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary hover:bg-ui-border hover:text-ink-primary transition-all"
                            data-modal-hide="modal-thembaohong">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form class="relative space-y-10" method="POST" action="{{ route('student.thembaohong') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-8">
                        <div class="space-y-2 group">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Chi tiết sự cố</label>
                            <textarea name="mota" rows="4" required
                                      class="pdu-input min-h-[140px] py-5 px-6 leading-relaxed"
                                      placeholder="Ví dụ: Bóng đèn hỏng, vòi nước rỉ tại vị trí giường số 2...">{{ old('mota') }}</textarea>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-ink-secondary/40 ml-1">Hình ảnh minh chứng</label>
                            <div class="relative group/upload">
                                <input type="file" name="anhminhhoa"
                                       class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0" />
                                <div class="flex flex-col items-center justify-center rounded-[2rem] border-2 border-dashed border-ui-border bg-ui-bg/30 p-10 transition-all group-hover/upload:border-brand-emerald/30 group-hover/upload:bg-brand-emerald/[0.02]">
                                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-brand-emerald shadow-sm ring-1 ring-ui-border group-hover/upload:scale-110 transition-transform">
                                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                    </div>
                                    <p class="text-[11px] font-black uppercase tracking-[0.2em] text-ink-secondary/50">Tải ảnh lên (Max 4MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="pdu-btn-primary w-full py-5 text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl shadow-brand-emerald/20 transition-all hover:-translate-y-1 active:translate-y-0">
                        Xác nhận gửi yêu cầu
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
