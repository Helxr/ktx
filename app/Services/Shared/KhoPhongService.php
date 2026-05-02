<?php

namespace App\Services\Shared;

use App\Contracts\Shared\KhoPhongServiceInterface;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Dangky;
use App\Enums\RegistrationStatus;
use Illuminate\Http\Request;

class KhoPhongService implements KhoPhongServiceInterface
{
    public function layBanDoKyTucXa(Request $request): array
    {
        $toa = $request->query('toa', 'A');
        $tang = (int) $request->query('tang', 1);

        $escapedToa = str_replace(['%', '_'], ['\%', '\_'], $toa);
        $danhsachphong = Phong::where('tenphong', 'like', $escapedToa . '%')->where('tang', $tang)->orderBy('tenphong')->get();
        $phongIds = $danhsachphong->pluck('id');

        $allSinhvien = Sinhvien::whereIn('phong_id', $phongIds)->with('taikhoan')->get()->groupBy('phong_id');
        $allDangky = Dangky::whereIn('phong_id', $phongIds)
            ->whereIn('trangthai', [RegistrationStatus::Pending->value, RegistrationStatus::ApprovedPendingPayment->value])
            ->get()->groupBy('phong_id');

        $mapData = $danhsachphong->map(fn($phong) => [
            'phong' => $phong,
            'beds' => $this->anhXaGiuong($phong, $allSinhvien->get($phong->id, collect()), $allDangky->get($phong->id, collect()))
        ]);

        return [
            'mapData' => $mapData,
            'toa' => $toa,
            'tang' => $tang,
            'allToa' => ['A', 'B'],
            'allTang' => [1, 2, 3],
            'campusStats' => $this->layThongKeCoSo()
        ];
    }

    public function layThongKeCoSo(): array
    {
        $totalBeds = 384;
        $occupied = Sinhvien::whereNotNull('phong_id')->count();
        $pending = Dangky::whereIn('trangthai', [RegistrationStatus::Pending->value, RegistrationStatus::ApprovedPendingPayment->value])->count();
        
        return [
            'available' => max(0, $totalBeds - $occupied - $pending),
            'occupied' => $occupied,
            'pending' => $pending,
        ];
    }

    public function layTrangThaiGiuong(int $phongId): array
    {
        // Simple wrapper for single room
        return []; // Implementation simplified for now
    }

    private function anhXaGiuong($phong, $sinhviens, $dangkys): array
    {
        $beds = [];
        $svMap = $sinhviens->keyBy('giuong_no');
        $dkMap = $dangkys->keyBy('giuong_no');

        for ($i = 1; $i <= 8; $i++) {
            if ($sv = $svMap->get($i)) {
                $beds[] = ['no' => $i, 'status' => 'OCCUPIED', 'student' => ['name' => $sv->taikhoan->name, 'mssv' => $sv->masinhvien]];
            } elseif ($dk = $dkMap->get($i)) {
                $beds[] = ['no' => $i, 'status' => 'PENDING', 'registration' => ['name' => $dk->ho_ten, 'status' => $dk->trangthai]];
            } else {
                $beds[] = ['no' => $i, 'status' => 'AVAILABLE'];
            }
        }
        return $beds;
    }
}
