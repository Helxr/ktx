<?php

namespace App\Traits;

use App\Models\Kyluat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

trait KiemtraKyluat
{
    public function kiemTraKyluat(int $sinhvienId): array
    {
        $mocSauThang = now()->subMonths(6)->startOfDay();

        $danhSachViPham = Kyluat::where('sinhvien_id', $sinhvienId)
            ->orderByDesc('ngayvipham')
            ->get();

        $loiConHieuLuc = $danhSachViPham->filter(function (Kyluat $kyluat) use ($mocSauThang) {
            return $this->laLoiConHieuLuc($kyluat, $mocSauThang);
        })->values();

        if ($loiConHieuLuc->isEmpty()) {
            return [
                'bi_chan' => false,
                'ly_do' => null,
                'loi_con_hieu_luc' => [],
            ];
        }

        return [
            'bi_chan' => true,
            'ly_do' => $this->taoThongDiepChanKyluat($loiConHieuLuc),
            'loi_con_hieu_luc' => $this->dinhDangDanhSachLoi($loiConHieuLuc),
        ];
    }

    private function laLoiConHieuLuc(Kyluat $kyluat, Carbon $mocSauThang): bool
    {
        return $this->laLoiChuaGiaiQuyet($kyluat) || $this->laLoiTrongSauThang($kyluat, $mocSauThang);
    }

    private function laLoiTrongSauThang(Kyluat $kyluat, Carbon $mocSauThang): bool
    {
        if (! $kyluat->ngayvipham) {
            return false;
        }

        return Carbon::parse($kyluat->ngayvipham)->greaterThanOrEqualTo($mocSauThang);
    }

    private function laLoiChuaGiaiQuyet(Kyluat $kyluat): bool
    {
        $duLieu = $kyluat->getAttributes();

        if (array_key_exists('da_giai_quyet', $duLieu)) {
            return ! $this->chuyenVeBoolean($duLieu['da_giai_quyet']);
        }

        if (array_key_exists('trangthai', $duLieu)) {
            return $this->laTrangThaiChuaGiaiQuyet((string) $duLieu['trangthai']);
        }

        if (array_key_exists('trang_thai', $duLieu)) {
            return $this->laTrangThaiChuaGiaiQuyet((string) $duLieu['trang_thai']);
        }

        if (array_key_exists('tinhtrang', $duLieu)) {
            return $this->laTrangThaiChuaGiaiQuyet((string) $duLieu['tinhtrang']);
        }

        if (array_key_exists('ngay_giai_quyet', $duLieu)) {
            return empty($duLieu['ngay_giai_quyet']);
        }

        if (array_key_exists('ngaygiaiquyet', $duLieu)) {
            return empty($duLieu['ngaygiaiquyet']);
        }

        return false;
    }

    private function chuyenVeBoolean(mixed $giaTri): bool
    {
        if (is_bool($giaTri)) {
            return $giaTri;
        }

        if (is_numeric($giaTri)) {
            return (int) $giaTri === 1;
        }

        $chuoi = strtolower(trim((string) $giaTri));

        return in_array($chuoi, ['1', 'true', 'yes', 'da', 'resolved', 'done'], true);
    }

    private function laTrangThaiChuaGiaiQuyet(string $trangThai): bool
    {
        $giaTri = $this->chuanHoaTrangThai($trangThai);

        return in_array($giaTri, [
            'chua giai quyet',
            'chua xu ly',
            'dang xu ly',
            'pending',
            'open',
            'moi tao',
            'cho xu ly',
        ], true);
    }

    private function chuanHoaTrangThai(string $giaTri): string
    {
        $giaTri = trim($giaTri);
        $khongDau = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $giaTri);
        if ($khongDau !== false) {
            $giaTri = $khongDau;
        }

        $giaTri = strtolower($giaTri);

        return preg_replace('/\s+/', ' ', $giaTri) ?? $giaTri;
    }

    private function taoThongDiepChanKyluat(Collection $loiConHieuLuc): string
    {
        $danhSach = $this->dinhDangDanhSachLoi($loiConHieuLuc);

        return 'Ban dang bi tam chan do cac vi pham con hieu luc: '.implode(' | ', $danhSach);
    }

    private function dinhDangDanhSachLoi(Collection $loiConHieuLuc): array
    {
        return $loiConHieuLuc->map(function (Kyluat $kyluat, int $index) {
            $ngay = $kyluat->ngayvipham ? Carbon::parse($kyluat->ngayvipham)->format('d/m/Y') : 'Khong ro ngay';
            $mucDoRaw = $kyluat->mucdo;
            $mucDo = $mucDoRaw instanceof \App\Enums\DisciplineLevel ? $mucDoRaw->label() : trim((string) ($mucDoRaw ?? 'Khong ro muc do'));
            $noiDung = trim((string) ($kyluat->noidung ?? 'Khong co noi dung'));

            return '#'.($index + 1).' ['.$ngay.'] '.$mucDo.': '.$noiDung;
        })->all();
    }
}

