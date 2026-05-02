<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Student\KyluatServiceInterface;
use App\Enums\DisciplineLevel;
use Illuminate\Http\Request;

class KyluatController extends Controller
{
    public function __construct(
        private readonly KyluatServiceInterface $kyLuatService
    ) {}

    public function lietKeKyLuatAdmin(Request $request)
    {
        $data = $this->kyLuatService->listKyluatAdmin($request);
        return view('admin.kyluat.danhsach', [
            ...$data,
            'selectedSinhvien' => $request->query('sinhvien_id', ''),
            'selectedMucDo' => $request->query('mucdo', ''),
        ]);
    }

    public function lietKeKyLuatSinhVien()
    {
        $data = $this->kyLuatService->listKyluatStudent();
        return view('student.kyluatcuaem', $data);
    }

    public function storeDiscipline(Request $request)
    {
        $duLieu = $request->validate([
            'sinhvien_id' => \App\Rules\CommonRules::sinhvienId(),
            'noidung' => ['required', 'string'],
            'ngayvipham' => ['required', 'date'],
            'mucdo' => ['required', 'string', 'in:' . implode(',', DisciplineLevel::values())],
        ]);

        $result = $this->kyLuatService->saveKyluat($duLieu);
        $type = $result['toast_loai'] ?? ($result['success'] ? 'thanhcong' : 'loi');
        return redirect()->back()->with(['toast_loai' => $type, 'toast_noidung' => $result['toast_noidung'] ?? $result['message']]);
    }

    public function updateDiscipline(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'noidung' => ['required', 'string'],
            'ngayvipham' => ['required', 'date'],
            'mucdo' => ['required', 'string', 'in:' . implode(',', DisciplineLevel::values())],
        ]);

        $result = $this->kyLuatService->saveKyluat($duLieu, $id);
        $type = $result['toast_loai'] ?? ($result['success'] ? 'thanhcong' : 'loi');
        return redirect()->back()->with(['toast_loai' => $type, 'toast_noidung' => $result['toast_noidung'] ?? $result['message']]);
    }
}
