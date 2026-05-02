<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KiemTraVaiTro
{
    /**
     * Kiem tra vai tro dang nhap theo route middleware.
     */
    public function handle(Request $request, Closure $next, string $vaitrobatbuoc): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $nguoiDung */
        $nguoiDung = Auth::user();
        $vaitrohientai = $nguoiDung->vaitro ?? null;

        $danhSachVaiTroBatBuoc = collect(explode(',', $vaitrobatbuoc))
            ->map(static fn (string $vaiTro): string => trim($vaiTro))
            ->filter()
            ->values();

        // "admin" duoc hieu la toan bo nhom quan tri (admin truong, admin toa nha, le tan...)
        if ($danhSachVaiTroBatBuoc->contains(User::ROLE_ADMIN)) {
            $danhSachVaiTroBatBuoc = $danhSachVaiTroBatBuoc
                ->merge([
                    User::ROLE_ADMIN,
                    User::ROLE_ADMIN_TRUONG,
                    User::ROLE_ADMIN_TOA_NHA,
                    User::ROLE_LE_TAN,
                ])
                ->unique()
                ->values();
        }

        $dungVaiTro = $danhSachVaiTroBatBuoc->contains((string) $vaitrohientai);

        if (! $dungVaiTro) {
            return redirect()
                ->route('dashboard')
                ->with('toast_loai', 'loi')
                ->with('toast_noidung', 'Ban khong co quyen truy cap chuc nang nay.');
        }

        return $next($request);
    }
}
