@extends('student.layouts.chinh')

@section('student_page_title', 'Lịch sử kỷ luật')

@section('noidung')
    <div class="mb-6 flex justify-end">
        <div class="flex items-center gap-3 rounded-xl bg-rose-50 border border-rose-100 px-4 py-3 shadow-sm">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-600 text-slate-100 shadow-sm">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <div class="text-[9px] font-black uppercase tracking-widest text-rose-600 opacity-60">Tổng vi phạm</div>
                <div class="text-sm font-black text-ink-primary tabular-nums tracking-tighter">{{ $kyluat->count() }} Lần</div>
            </div>
        </div>
    </div>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <article class="overflow-hidden rounded-[2rem] border border-ui-border bg-ui-card/50 backdrop-blur-xl shadow-sm transition-all hover:border-brand-emerald/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-primary">
                    <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                        <tr>
                            <th class="px-8 py-5">Ngày vi phạm</th>
                            <th class="px-8 py-5">Nội dung vi phạm</th>
                            <th class="px-8 py-5 text-center">Mức độ xử lý</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @forelse ($kyluat as $item)
                            <tr class="group transition-colors hover:bg-ui-bg/30">
                                <td class="px-8 py-6">
                                    <div class="font-display text-lg font-black text-ink-primary tabular-nums tracking-tight">{{ date('d/m/Y', strtotime($item->ngayvipham)) }}</div>
                                    <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-1">Học kỳ {{ date('m') > 6 ? 'I' : 'II' }} • {{ date('Y') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="max-w-md">
                                        <div class="font-bold text-ink-primary text-sm leading-snug tracking-tight">{{ $item->noidung }}</div>
                                        <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-1.5 flex items-center gap-1.5">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Chi tiết biên bản số #KL-{{ str_pad((string)$item->id, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $mucdo = strtolower($item->mucdo);
                                        $badgeClass = match(true) {
                                            str_contains($mucdo, 'nặng') || str_contains($mucdo, 'buộc') => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 animate-pulse',
                                            str_contains($mucdo, 'cảnh cáo') || str_contains($mucdo, 'trung bình') => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                            default => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                                        {{ $item->mucdo }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-24 text-center">
                                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-600/30 mb-6">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight">Hồ sơ trong sạch</h3>
                                    <p class="mt-2 text-xs font-medium text-ink-secondary/60 max-w-sm mx-auto">Tuyệt vời! Bạn không có bất kỳ hồ sơ vi phạm kỷ luật nào tại KTX.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        @if(method_exists($kyluat, 'links'))
            <div class="mt-8">
                {{ $kyluat->links() }}
            </div>
        @endif
    </div>
@endsection
