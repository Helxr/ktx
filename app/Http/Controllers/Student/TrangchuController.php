<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\BangDieuKhienServiceInterface;

class TrangchuController extends Controller
{
    public function __construct(
        private readonly BangDieuKhienServiceInterface $bangDieuKhienService
    ) {}

    public function index()
    {
        $data = $this->bangDieuKhienService->layDuLieuBangDieuKhienSinhVien();
        return view('student.trangchu', $data);
    }
}
