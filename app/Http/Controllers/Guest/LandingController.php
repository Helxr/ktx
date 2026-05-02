<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TrangChuServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __construct(
        private readonly TrangChuServiceInterface $trangChuService
    ) {}

    public function index(): View
    {
        return view('landing.index', $this->trangChuService->layDuLieuTrangChu());
    }

    public function guiLienHe(Request $request): RedirectResponse
    {
        $duLieu = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'noi_dung' => ['required', 'string', 'max:2000'],
        ]);

        $this->trangChuService->guiLienHe($duLieu);

        return redirect()->to(route('home').'#lien-he')->with('lienhe_thanhcong', 'Cảm ơn bạn đã liên hệ. Ban quản lý sẽ phản hồi sớm.');
    }
}
