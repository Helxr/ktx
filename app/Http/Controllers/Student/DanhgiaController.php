<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Student\DanhgiaServiceInterface;
use Illuminate\Http\Request;

class DanhgiaController extends Controller
{
    public function __construct(
        private readonly DanhgiaServiceInterface $danhgiaService
    ) {}

    public function showReviewForm()
    {
        $data = $this->danhgiaService->getReviewFormContext();
        if (isset($data['error'])) {
            return redirect()->route('student.trangchu')->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        return view('student.danhgia.form', $data);
    }

    public function storeReview(Request $request)
    {
        $dulieu = $request->validate([
            'diem' => ['required', 'integer', 'min:1', 'max:5'],
            'noidung' => ['nullable', 'string', 'max:500'],
        ]);

        $result = $this->danhgiaService->storeReview($dulieu);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }
}
