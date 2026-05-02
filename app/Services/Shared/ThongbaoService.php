<?php

namespace App\Services\Shared;

use App\Contracts\Shared\ThongbaoServiceInterface;
use App\Models\Thongbao;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;

class ThongbaoService implements ThongbaoServiceInterface
{
    use PhanHoiService;

    public function indexForStudent(Request $yeuCau): array
    {
        $loai = $yeuCau->query('loai', 'tatca');

        $query = Thongbao::where(function ($truyVan) {
            $truyVan->where('doituong', 'sinhvien')
                ->orWhere('doituong', 'tatca')
                ->orWhereNull('doituong');
        });

        if ($loai === 'moi_nhat') {
            $query->where('ngaydang', '>=', now()->subDays(7));
        }

        return [
            'thongbao' => $query->orderByDesc('ngaydang')->paginate(15),
            'loai' => $loai,
            'thongKe' => [
                'tong_so' => $query->count(),
                'trong_thang' => (clone $query)->whereYear('ngaydang', now()->year)->whereMonth('ngaydang', now()->month)->count(),
                'tuan_nay' => (clone $query)->where('ngaydang', '>=', now()->subDays(7))->count(),
            ],
        ];
    }

    public function showForStudent(int $id): array
    {
        $query = Thongbao::where('id', $id)->where(function ($truyVan) {
            $truyVan->where('doituong', 'sinhvien')
                ->orWhere('doituong', 'tatca')
                ->orWhereNull('doituong');
        });

        $thongbao = $query->first();
        if (! $thongbao) {
            return $this->traVeLoi('Khong tim thay thong bao.');
        }

        $thongbaoLienQuan = Thongbao::where('id', '<>', $id)
            ->where(function ($truyVan) {
                $truyVan->where('doituong', 'sinhvien')
                    ->orWhere('doituong', 'tatca')
                    ->orWhereNull('doituong');
            })
            ->orderByDesc('ngaydang')
            ->limit(5)
            ->get();

        return [
            'thongbao' => $thongbao,
            'thongbaoLienQuan' => $thongbaoLienQuan,
        ];
    }

    public function indexForAdmin(): array
    {
        return [
            'thongbao' => Thongbao::orderByDesc('ngaydang')->paginate(20),
        ];
    }

    public function store(array $duLieu): array
    {
        try {
            $thongbao = new Thongbao();
            $thongbao->fill([
                'tieude' => $duLieu['tieude'],
                'noidung' => $duLieu['noidung'],
                'doituong' => $duLieu['doituong'] ?? 'tatca',
                'ngaydang' => $duLieu['ngaydang'] ?? now(),
            ])->save();

            return $this->traVeThanhCong('Thao tac thanh cong.');
        } catch (\Throwable $throwable) {
            return $this->traVeLoi($throwable->getMessage());
        }
    }

    public function update(int $id, array $duLieu): array
    {
        try {
            $thongbao = Thongbao::find($id);
            if (! $thongbao) {
                return $this->traVeLoi('Khong tim thay thong bao.');
            }

            $thongbao->fill([
                'tieude' => $duLieu['tieude'],
                'noidung' => $duLieu['noidung'],
                'doituong' => $duLieu['doituong'] ?? 'tatca',
                'ngaydang' => $duLieu['ngaydang'] ?? now(),
            ])->save();

            return $this->traVeThanhCong('Thao tac thanh cong.');
        } catch (\Throwable $throwable) {
            return $this->traVeLoi($throwable->getMessage());
        }
    }

    public function destroy(int $id): array
    {
        try {
            $thongbao = Thongbao::find($id);
            if (! $thongbao) {
                return $this->traVeLoi('Khong tim thay thong bao.');
            }

            $thongbao->delete();
            return $this->traVeThanhCong('Xoa thanh cong.');
        } catch (\Throwable $throwable) {
            return $this->traVeLoi($throwable->getMessage());
        }
    }
}

