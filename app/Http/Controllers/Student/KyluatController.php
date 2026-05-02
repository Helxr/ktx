<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Student\KyluatServiceInterface;

class KyluatController extends Controller
{
    public function __construct(
        private readonly KyluatServiceInterface $kyluatService
    ) {}

    /**
     * Discipline history of current student.
     */
    public function lietKeKyLuatSinhVien()
    {
        $data = $this->kyluatService->listKyluatStudent();
        return view('student.kyluatcuaem', $data);
    }
}
