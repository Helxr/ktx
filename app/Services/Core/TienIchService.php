<?php

namespace App\Services\Core;

use App\Contracts\Core\TienIchServiceInterface;
use App\Models\Cauhinh;
use App\Models\Lienhe;
use App\Models\Thongbao;
use Illuminate\Http\Request;

class TienIchService implements TienIchServiceInterface
{
    public function layCauHinh(): array
    {
        return Cauhinh::all()->pluck('giatri', 'ten')->toArray();
    }

    public function capNhatCauHinh(array $data): void
    {
        foreach ($data as $key => $value) {
            Cauhinh::updateOrCreate(['ten' => $key], ['giatri' => $value]);
        }
    }

    public function danhSachThongBao(string $target = 'all'): array
    {
        return Thongbao::when($target !== 'all', fn ($q) => $q->where('doituong', $target))
            ->orderByDesc('ngaydang')
            ->get()
            ->toArray();
    }

    public function guiThongBao(array $data): void
    {
        Thongbao::create([
            'tieude' => $data['tieude'],
            'noidung' => $data['noidung'],
            'doituong' => $data['doituong'] ?? 'sinhvien',
            'ngaydang' => now(),
            'phong_id' => $data['phong_id'] ?? null,
            'sinhvien_id' => $data['sinhvien_id'] ?? null,
        ]);
    }

    public function danhSachLienHe(Request $request): array
    {
        $tuKhoa = trim((string) $request->query('q', ''));
        $trangThai = (string) $request->query('trang_thai', 'tatca');

        $query = Lienhe::query()
            ->when($tuKhoa !== '', function ($q) use ($tuKhoa) {
                $q->where(function ($sub) use ($tuKhoa) {
                    $sub->where('ho_ten', 'like', "%{$tuKhoa}%")
                        ->orWhere('email', 'like', "%{$tuKhoa}%")
                        ->orWhere('noi_dung', 'like', "%{$tuKhoa}%");
                });
            })
            ->when($trangThai !== 'tatca', fn ($q) => $q->where('trang_thai', $trangThai))
            ->orderByDesc('created_at');

        $lienhe = $query->paginate(20)->withQueryString();

        $thongKe = [
            'chua_xu_ly' => Lienhe::where('trang_thai', Lienhe::TRANG_THAI_CHUA_XU_LY)->count(),
            'da_xu_ly' => Lienhe::where('trang_thai', Lienhe::TRANG_THAI_DA_XU_LY)->count(),
        ];

        return [
            'danhsachlienhe' => $lienhe,
            'tuKhoa' => $tuKhoa,
            'trangThai' => $trangThai,
            'thongKe' => $thongKe,
        ];
    }

    public function capNhatTrangThaiLienHe(int $id, string $status, ?string $note = null): void
    {
        $contact = Lienhe::find($id);
        if (! $contact) {
            return;
        }

        $duLieu = [
            'trang_thai' => $status,
        ];

        if ($note !== null && in_array('ghi_chu_admin', $contact->getFillable(), true)) {
            $duLieu['ghi_chu_admin'] = $note;
        }

        $contact->update($duLieu);
    }
}
