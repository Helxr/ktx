<?php

namespace App\Services\Admin;

use App\Contracts\Admin\BangDieuKhienServiceInterface;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\RegistrationStatus;
use App\Models\Baohong;
use App\Models\Dangky;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Kyluat;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Taisan;
use App\Models\Thongbao;
use Illuminate\Support\Facades\Auth;

class BangDieuKhienService implements BangDieuKhienServiceInterface
{
    public function layDuLieuBangDieuKhienAdmin(): array
    {
        $now = now(); $t = (int)$now->month; $n = (int)$now->year;
        return [
            'vaitro' => Auth::user()->vaitro ?? 'admin', 'tongphong' => Phong::count(), 'tongphongtrong' => $this->demPhongConTrong(),
            'tongsinhvien' => Sinhvien::count(), 'dangkychoxuly' => Dangky::where('trangthai', RegistrationStatus::Pending->value)->count(),
            'baohongchosua' => Baohong::where('trangthai', \App\Enums\MaintenanceStatus::Pending->value)->count(),
            'hoadonchuathanhtoan' => Hoadon::where('thang', $t)->where('nam', $n)->where('trangthaithanhtoan', InvoiceStatus::Pending->value)->count(),
            'doanhthuthang' => (int)Hoadon::where('thang', $t)->where('nam', $n)->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->sum('tongtien'),
            'danhsachdangkygannhat' => Dangky::where('trangthai', RegistrationStatus::Pending->value)->orderByDesc('id')->limit(5)->get(),
            'danhsachbaohonggannhat' => Baohong::where('trangthai', \App\Enums\MaintenanceStatus::Pending->value)->orderByDesc('id')->limit(5)->get(),
            'thanghientai' => $t, 'namhientai' => $n, 'doanhthugannhat' => $this->layXuHuongDoanhThu(), 'nhan' => $this->layNhanDoanhThu(),
            'thongbao' => Thongbao::orderByDesc('ngaydang')->limit(5)->get(), 'hopdongsaphethan' => $this->layHopDongSapHetHan(),
            'diennuocbathuong' => $this->layTieuThuBatThuong($t, $n),
        ];
    }

    public function layDuLieuBangDieuKhienSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        $t = (int)now()->month; $n = (int)now()->year;

        $data = [
            'vaitro' => Auth::user()->vaitro ?? 'sinhvien', 'thanghientai' => $t, 'namhientai' => $n,
            'sinhvien' => $sinhvien, 'phonghientai' => null, 'taisanphong' => collect(),
            'thanhviencungphong' => collect(), 'kyluatcuaem' => collect(),
            'hoadonchuathanhtoan' => collect(), 'hoadonChoXacNhan' => collect(),
            'lienhekhancap' => [['title' => 'Bảo vệ', 'phone' => '0900 111 222'], ['title' => 'Y tế', 'phone' => '0900 333 444']],
            'thongbao' => $this->layThongBaoChoSinhVien($sinhvien),
        ];

        if ($sinhvien && $sinhvien->phong_id) {
            $data['phonghientai'] = Phong::find($sinhvien->phong_id);
            $data['thanhviencungphong'] = Sinhvien::where('phong_id', $sinhvien->phong_id)->where('id', '<>', $sinhvien->id)->get();
            $data['kyluatcuaem'] = Kyluat::where('sinhvien_id', $sinhvien->id)->orderByDesc('ngayvipham')->limit(5)->get();
            $data['hoadonchuathanhtoan'] = Hoadon::where('phong_id', $sinhvien->phong_id)->where('trangthaithanhtoan', InvoiceStatus::Pending->value)->get();
            $data['hoadonChoXacNhan'] = Hoadon::where('sinhvien_id', $sinhvien->id)->where('trangthaithanhtoan', InvoiceStatus::PendingConfirmation->value)->get();
            $data['taisanphong'] = Taisan::where('phong_id', $sinhvien->phong_id)->get();
        }

        return $data;
    }

    private function layThongBaoChoSinhVien($sinhvien)
    {
        return Thongbao::where(function ($q) use ($sinhvien) {
            $q->where('doituong', 'sinhvien')->whereNull('phong_id')->whereNull('sinhvien_id');
            if ($sinhvien?->phong_id) $q->orWhere(fn($sq) => $sq->where('doituong', 'sinhvien')->where('phong_id', $sinhvien->phong_id));
            if ($sinhvien) $q->orWhere(fn($sq) => $sq->where('doituong', 'sinhvien')->where('sinhvien_id', $sinhvien->id));
        })->orderByDesc('ngaydang')->limit(5)->get();
    }

    private function demPhongConTrong(): int
    {
        return Phong::all()->filter(fn($p) => Sinhvien::where('phong_id', $p->id)->count() < (int)$p->succhuamax)->count();
    }

    private function layXuHuongDoanhThu(): array
    {
        $tienphong = []; $tiendichvu = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i); $t = (int)$m->month; $n = (int)$m->year;
            $tienphong[] = (int)Hoadon::where('thang', $t)->where('nam', $n)->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->sum('tienphong');
            $tiendichvu[] = (int)Hoadon::where('thang', $t)->where('nam', $n)->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->sum('tiendien') + (int)Hoadon::where('thang', $t)->where('nam', $n)->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->sum('tiennuoc');
        }
        return ['tienphong' => $tienphong, 'tiendichvu' => $tiendichvu];
    }

    private function layNhanDoanhThu(): array { $labels = []; for ($i = 5; $i >= 0; $i--) { $labels[] = now()->subMonths($i)->format('m/Y'); } return $labels; }

    private function layHopDongSapHetHan() {
        return Hopdong::where('trang_thai', ContractStatus::Active->value)->whereDate('ngay_ket_thuc', '<=', now()->addDays(30))->whereDate('ngay_ket_thuc', '>=', now())
            ->with(['sinhvien.taikhoan', 'phong'])->orderBy('ngay_ket_thuc')->limit(10)->get();
    }

    private function layTieuThuBatThuong(int $t, int $n) {
        $hoadonThangTruoc = Hoadon::where('thang', now()->subMonth()->month)->where('nam', now()->subMonth()->year)->get()->keyBy('phong_id');
        $hoadonThangNay = Hoadon::where('thang', $t)->where('nam', $n)->with('phong')->get();
        $abnormal = [];
        foreach ($hoadonThangNay as $h) {
            if ($ht = $hoadonThangTruoc->get($h->phong_id)) {
                $dTn = $h->chisodienmoi - $h->chisodiencu; $dTt = $ht->chisodienmoi - $ht->chisodiencu;
                if ($dTt > 0 && $dTn > $dTt * 1.5) $abnormal[] = ['phong' => $h->phong, 'loai' => 'Điện', 'thang_truoc' => $dTt, 'thang_nay' => $dTn, 'ty_le_tang' => round((($dTn - $dTt) / $dTt) * 100, 1)];
            }
        }
        return collect($abnormal);
    }
}
