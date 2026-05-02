<x-admin-layout>
    <x-slot:title>Quản lý phòng</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Hệ thống phòng nội trú</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Quản lý quỹ phòng và nhân khẩu lưu trú.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <form action="{{ route('admin.quanlyphong') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <div class="relative group">
                    <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-ink-secondary/40 group-focus-within:text-ink-primary transition-colors">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Tên phòng..." class="w-full sm:w-44 rounded-xl border border-ui-border bg-white py-2 pl-9 pr-4 text-xs font-medium text-ink-primary placeholder:text-ink-secondary/30 focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all" />
                </div>
                
                <select name="tang" class="rounded-xl border border-ui-border bg-white py-2 pl-3 pr-8 text-[10px] font-bold text-ink-primary focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all" onchange="this.form.submit()">
                    <option value="">Tất cả tầng</option>
                    @for ($i = 1; $i <= 3; $i++)
                        <option value="{{ $i }}" {{ request('tang') == $i ? 'selected' : '' }}>Tầng {{ $i }}</option>
                    @endfor
                </select>
                
                <button type="submit" class="rounded-xl bg-ink-primary px-4 py-2 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                    Truy vấn
                </button>
            </form>
        </div>
    </div>

    <div class="mb-8 flex items-center justify-center">
        <div class="inline-flex rounded-2xl bg-ui-card p-1.5 shadow-sm border border-ui-border">
            <a href="{{ route('admin.quanlyphong', array_merge(request()->query(), ['view' => 'table'])) }}" 
               class="flex items-center gap-2 rounded-xl px-6 py-2.5 text-sm font-black uppercase tracking-widest transition-all {{ $viewMode === 'table' ? 'bg-ui-bg text-brand-emerald shadow-sm' : 'text-ink-secondary hover:text-ink-primary' }}">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Danh sách
            </a>
            <a href="{{ route('admin.quanlyphong', array_merge(request()->query(), ['view' => 'grid'])) }}" 
               class="flex items-center gap-2 rounded-xl px-6 py-2.5 text-sm font-black uppercase tracking-widest transition-all {{ $viewMode === 'grid' ? 'bg-ui-bg text-brand-emerald shadow-sm' : 'text-ink-secondary hover:text-ink-primary' }}">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Sơ đồ khối
            </a>
        </div>
    </div>

    @if ($viewMode === 'table')
        <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-primary">
                    <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                        <tr>
                            <th class="px-6 py-4 font-bold">Tên phòng</th>
                            <th class="px-6 py-4 font-bold">Loại phòng</th>
                            <th class="px-6 py-4 font-bold">Giới tính</th>
                            <th class="px-6 py-4 font-bold">Lấp đầy</th>
                            <th class="px-6 py-4 font-bold">Tình trạng</th>
                            <th class="px-6 py-4 font-bold">Đơn giá</th>
                            <th class="px-6 py-4 font-bold text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @forelse ($danhsachphong as $phong)
                            @php
                                $soluongdango = $soluongdango_theophong[$phong->id] ?? 0;
                                $daydu = $soluongdango >= (int) $phong->soluongtoida;
                                $phantram = $phong->soluongtoida > 0 ? min(100, round($soluongdango / $phong->soluongtoida * 100)) : 0;
                            @endphp
                            <tr class="group transition-colors hover:bg-ui-bg/50">
                                <td class="px-6 py-4">
                                    <div class="font-black text-ink-primary font-display text-lg uppercase tracking-tight">{{ $phong->tenphong }}</div>
                                    <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary mt-0.5">Tầng vận hành {{ $phong->tang }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-ink-secondary">{{ $phong->succhuamax }} người</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-wider {{ $phong->gioitinh === 'Nam' ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10' : 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-700/10' }}">
                                        {{ $phong->gioitinh }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-1.5 min-w-[80px] overflow-hidden rounded-full bg-ui-bg ring-1 ring-inset ring-ui-border">
                                            <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $daydu ? 'bg-ink-primary' : 'bg-brand-emerald' }}" style="width: {{ $phantram }}%"></div>
                                        </div>
                                        <span class="text-xs font-black text-ink-primary tabular-nums tracking-widest">{{ $soluongdango }}/{{ $phong->soluongtoida }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $daydu ? 'bg-ink-primary text-white' : 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $daydu ? 'bg-white' : 'bg-emerald-500' }}"></span>
                                        {{ $daydu ? 'Đầy' : 'Còn chỗ' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-ink-primary tabular-nums">{{ number_format($phong->giaphong, 0, ',', '.') }}đ</div>
                                    <div class="text-[10px] text-ink-secondary font-bold uppercase mt-0.5">Mỗi tháng</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.chitietphong', ['id' => $phong->id]) }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chi tiết">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <button type="button" data-modal-target="modal-capnhatphong-{{ $phong->id }}" data-modal-toggle="modal-capnhatphong-{{ $phong->id }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chỉnh sửa">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                    <form method="POST" action="{{ route('admin.xoaphong', ['id' => $phong->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @click="$dispatch('open-confirm', { message: 'Xóa phòng {{ $phong->tenphong }}?', action: () => showConfirm = true })" class="flex h-8 w-8 items-center justify-center rounded-lg border border-rose-100 bg-rose-50 text-rose-600 shadow-sm transition-colors hover:bg-rose-600 hover:text-white" title="Xóa">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Không tìm thấy phòng nào</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Thử thay đổi từ khóa tìm kiếm hoặc tạo phòng mới.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($danhsachphong, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $danhsachphong->appends(request()->query())->links() }}
            </div>
        @endif
    </article>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($danhsachphong as $phong)
                @php
                    $soluongdango = $soluongdango_theophong[$phong->id] ?? 0;
                    $daydu = $soluongdango >= (int) $phong->soluongtoida;
                    $phantram = $phong->soluongtoida > 0 ? min(100, round($soluongdango / $phong->soluongtoida * 100)) : 0;
                    $isFemale = $phong->gioitinh === 'Nữ';
                @endphp
                <article class="overflow-hidden rounded-2xl border border-ui-border bg-white shadow-sm transition-all hover:shadow-md flex flex-col">
                    <div class="h-2.5 w-full {{ $daydu ? 'bg-ink-primary' : ($isFemale ? 'bg-rose-500' : 'bg-brand-emerald') }}"></div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <header class="mb-6 flex items-start justify-between">
                            <div>
                                <h2 class="text-3xl font-black text-ink-primary font-display uppercase tracking-tight">{{ $phong->tenphong }}</h2>
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary mt-1">Tầng vận hành {{ $phong->tang }}</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $isFemale ? 'bg-rose-50 text-rose-600 ring-1 ring-inset ring-rose-500/20' : 'bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-500/20' }}">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </header>

                        <div class="mb-6 flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-ink-secondary">Tỷ lệ lấp đầy</span>
                                <span class="text-sm font-black text-ink-primary tabular-nums">{{ $soluongdango }}/{{ $phong->soluongtoida }}</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-ui-bg ring-1 ring-inset ring-ui-border">
                                <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $daydu ? 'bg-ink-primary' : 'bg-brand-emerald' }}" style="width: {{ $phantram }}%"></div>
                            </div>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Giá thuê</div>
                                <div class="font-bold text-ink-primary tabular-nums">{{ number_format($phong->giaphong, 0, ',', '.') }}đ</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 border-t border-ui-border pt-4">
                            <a href="{{ route('admin.chitietphong', ['id' => $phong->id]) }}" class="flex h-9 w-9 items-center justify-center rounded-xl border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chi tiết">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button type="button" data-modal-target="modal-capnhatphong-{{ $phong->id }}" data-modal-toggle="modal-capnhatphong-{{ $phong->id }}" class="flex h-9 w-9 items-center justify-center rounded-xl border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chỉnh sửa">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.xoaphong', ['id' => $phong->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="button" @click="$dispatch('open-confirm', { message: 'Xóa phòng {{ $phong->tenphong }}?', action: () => showConfirm = true })" class="flex h-9 w-9 items-center justify-center rounded-xl border border-rose-100 bg-rose-50 text-rose-600 shadow-sm transition-colors hover:bg-rose-600 hover:text-white" title="Xóa">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-ui-border bg-ui-bg/50 py-24 text-center">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-ink-secondary/50 mb-4 shadow-sm border border-ui-border">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-ink-primary">Dữ liệu trống</h3>
                        <p class="mt-1 text-[11px] text-ink-secondary max-w-sm mx-auto">Vui lòng thêm phòng mới để bắt đầu quản lý vận hành cơ sở vật chất.</p>
                    </div>
                </div>
            @endforelse
        </div>
        @if(method_exists($danhsachphong, 'links'))
            <div class="mt-6">
                {{ $danhsachphong->appends(request()->query())->links() }}
            </div>
        @endif
    @endif

    @push('modals')
        <x-modal id="modal-themphong" title="Kiến tạo phòng mới" subtitle="Nhập thông số cơ bản để khởi tạo thực thể phòng trong hệ thống.">
            <form method="POST" action="{{ route('admin.themphong') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tên phòng nhận diện</label>
                        <input name="tenphong" value="{{ old('tenphong') }}" class="linear-input mt-1.5" placeholder="VD: P.101" required />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tầng vận hành</label>
                        <input name="tang" type="number" value="{{ old('tang') }}" class="linear-input mt-1.5" placeholder="1-8" required />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Đơn giá thuê (VND)</label>
                        <input name="giaphong" type="number" value="{{ old('giaphong') }}" class="linear-input mt-1.5" placeholder="1200000" required />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Giới tính chỉ định</label>
                        <select name="gioitinh" class="linear-select mt-1.5" required>
                            <option value="Nam">Nam giới</option>
                            <option value="Nữ">Nữ giới</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Số lượng giường</label>
                        <input name="soluongtoida" type="number" value="{{ old('soluongtoida', 8) }}" class="linear-input mt-1.5" required />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Sức chứa tối đa</label>
                        <input name="succhuamax" type="number" value="{{ old('succhuamax', 8) }}" class="linear-input mt-1.5" required />
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Mô tả đặc tính</label>
                    <textarea name="mota" rows="3" class="linear-textarea mt-1.5" placeholder="Tiện nghi, ghi chú đặc biệt..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-themphong" class="flex-1 linear-btn-secondary py-3 font-bold">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] linear-btn-primary py-3 font-bold shadow-lg shadow-brand/20">Khởi tạo thực thể</button>
                </div>
            </form>
        </x-modal>

        @foreach ($danhsachphong as $phong)
            <x-modal id="modal-capnhatphong-{{ $phong->id }}" title="Hiệu chỉnh tham số" subtitle="Cập nhật thông tin thực thể phòng {{ $phong->tenphong }}.">
                <form method="POST" action="{{ route('admin.capnhatphong', ['id' => $phong->id]) }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tên phòng</label>
                            <input name="tenphong" value="{{ $phong->tenphong }}" class="linear-input mt-1.5" required />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Giới tính</label>
                            <select name="gioitinh" class="linear-select mt-1.5" required>
                                <option value="Nam" {{ $phong->gioitinh === 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ $phong->gioitinh === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tầng</label>
                            <input name="tang" type="number" value="{{ $phong->tang }}" class="linear-input mt-1.5" required />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Đơn giá</label>
                            <input name="giaphong" type="number" value="{{ $phong->giaphong }}" class="linear-input mt-1.5" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Số giường</label>
                            <input name="soluongtoida" type="number" value="{{ $phong->soluongtoida }}" class="linear-input mt-1.5" required />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Sức chứa</label>
                            <input name="succhuamax" type="number" value="{{ $phong->succhuamax }}" class="linear-input mt-1.5" required />
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Mô tả đặc tính</label>
                        <textarea name="mota" rows="3" class="linear-textarea mt-1.5">{{ $phong->mota }}</textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-capnhatphong-{{ $phong->id }}" class="flex-1 linear-btn-secondary py-3 font-bold">Hủy bỏ</button>
                        <button type="submit" class="flex-[2] linear-btn-primary py-3 font-bold">Lưu thay đổi</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
