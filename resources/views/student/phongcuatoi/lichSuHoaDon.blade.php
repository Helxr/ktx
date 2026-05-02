@extends('student.layouts.chinh')

@section('noidung')
    <div class="mb-6">
        <a href="{{ route('student.phongcuatoi') }}" class="inline-flex items-center text-xs font-bold text-ink-secondary/40 hover:text-brand-emerald transition-colors">
            <svg class="mr-2 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Quay lại Phòng của tôi
        </a>
    </div>

    {{-- Thống kê --}}
    <div class="mb-6 grid gap-4 sm:grid-cols-4">
        <div class="rounded-xl border border-gray-200/70 bg-ui-card p-4">
            <div class="text-2xl font-bold text-[#121212]">{{ $thongKe['tong_hoa_don'] }}</div>
            <div class="text-xs text-[#606060]">Tổng hóa đơn</div>
        </div>
        <div class="rounded-xl border border-green-200 bg-green-50 p-4">
            <div class="text-2xl font-bold text-green-700">{{ $thongKe['da_thanh_toan'] }}</div>
            <div class="text-xs text-green-600">Đã thanh toán</div>
        </div>
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="text-2xl font-bold text-red-700">{{ $thongKe['chua_thanh_toan'] }}</div>
            <div class="text-xs text-red-600">Chưa thanh toán</div>
        </div>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
            <div class="text-2xl font-bold text-blue-700">{{ number_format($thongKe['tong_tien_da_tra']) }} đ</div>
            <div class="text-xs text-blue-600">Đã thanh toán</div>
        </div>
    </div>

    {{-- Danh sách hóa đơn --}}
    <div class="rounded-xl border border-gray-200/70 bg-ui-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#606060]">
                <x-table-header>
                    <tr>
                        <th class="px-6 py-3">Tháng/Năm</th>
                        <th class="px-6 py-3">Tổng tiền</th>
                        <th class="px-6 py-3">Trạng thái</th>
                        <th class="px-6 py-3">Ngày xuất</th>
                        <th class="px-6 py-3 text-right">Thao tác</th>
                    </tr>
                </x-table-header>
                <tbody>
                    @forelse($hoadon as $hoadon)
                        <tr class="border-t border-gray-200/70">
                            <td class="px-6 py-4 font-medium text-[#121212]">{{ $hoadon->thang }}/{{ $hoadon->nam }}</td>
                            <td class="px-6 py-4">{{ number_format($hoadon->tongtien) }} đ</td>
                            <td class="px-6 py-4">
                                @if($hoadon->trangthaithanhtoan === 'Đã thanh toán')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Đã thanh toán</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">Chưa thanh toán</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $hoadon->ngayxuat ? date('d/m/Y', strtotime($hoadon->ngayxuat)) : '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('student.phongcuatoi.hoadon.chitiet', $hoadon->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-gray-200/70">
                            <td class="px-6 py-4 text-center" colspan="5">
                                <div class="py-8">
                                    <svg class="mx-auto mb-4 h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm text-[#606060]">Chưa có hóa đơn nào</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $hoadon->links() }}
        </div>
    </div>
@endsection
