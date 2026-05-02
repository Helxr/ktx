<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Giao thức Shared Controllers
use App\Http\Controllers\Shared\FileController;
use App\Http\Controllers\Shared\ProfileController;

// --------------------------------------------------------------------------
// 1. GUEST / PUBLIC ROUTES
// --------------------------------------------------------------------------
Route::namespace('App\Http\Controllers\Guest')->group(function () {
    Route::get('/', 'LandingController@index')->name('home');
    Route::post('/lien-he', 'LandingController@guiLienHe')->name('landing.lienhe');

    // Guest Registration & Lookup
    Route::prefix('dang-ky-ktx')->name('guest.dangky.')->group(function () {
        Route::get('/', 'DangkyController@create')->name('create');
        Route::post('/', 'DangkyController@store')->name('store');
    });
    Route::get('/tra-cuu-don/{token?}', 'DangkyController@lookup')->name('guest.lookup');

    // Public Room Info
    Route::prefix('phong')->name('public.')->group(function () {
        Route::get('/', 'PhongController@index')->name('danhsachphong');
        Route::get('/{id}/vattu', 'PhongController@assets')->name('chitietvattu');
    });
});

// --------------------------------------------------------------------------
// 2. ADMIN ROUTES
// --------------------------------------------------------------------------
Route::prefix('admin')
    ->middleware(['auth', 'kiemtravaitro:admin,admin_truong,admin_toanha,le_tan'])
    ->namespace('App\Http\Controllers\Admin')
    ->name('admin.')
    ->group(function () {
        
        Route::get('/trangchu', 'TrangchuController@index')->name('trangchu');

        // Quản lý Phòng & Sơ đồ
        Route::controller('PhongController')->group(function () {
            Route::get('/quanlyphong', 'index')->name('quanlyphong');
            Route::get('/sodophong', 'map')->name('phong.map');
            Route::post('/themphong', 'store')->name('themphong');
            Route::post('/capnhatphong/{id}', 'update')->name('capnhatphong');
            Route::post('/xoaphong/{id}', 'destroy')->name('xoaphong');
            Route::get('/quanlyphong/{id}', 'show')->name('chitietphong');
            
            // Tài sản & Vật tư (Inventory)
            Route::post('/quanlyphong/{id}/themtaisan', 'storeAsset')->name('themtaisan');
            Route::post('/quanlyphong/{id}/capnhattaisan/{taisanId}', 'updateAsset')->name('capnhattaisan');
            Route::post('/quanlyphong/{id}/xoataisan/{taisanId}', 'destroyAsset')->name('xoataisan');
            Route::post('/quanlyphong/{id}/themvattu', 'storeSupply')->name('themvattu');
            Route::post('/quanlyphong/{id}/capnhatvattu/{vattuId}', 'updateSupply')->name('capnhatvattu');
            Route::post('/quanlyphong/{id}/xoavattu/{vattuId}', 'destroySupply')->name('xoavattu');
        });

        // Quản lý Sinh viên
        Route::controller('SinhvienController')->group(function () {
            Route::get('/quanlysinhvien', 'lietKeSinhVien')->name('quanlysinhvien');
            Route::post('/chuyenphong/{id}', 'chuyenPhong')->name('chuyenphong');
            Route::post('/choroiophong/{id}', 'choRoiOPhong')->name('choroiophong');
            Route::post('/capnhatsinhvien/{id}', 'capNhatSinhVien')->name('capnhatsinhvien');
        });

        // Quản lý Đăng ký (Registrations)
        Route::controller('DangkyController')->middleware('can:dangky.review')->group(function () {
            Route::get('/duyetdangky', 'lietKeDangKyAdmin')->name('duyetdangky');
            Route::post('/duyetdangky/{id}', 'duyetDangKy')->name('xulyduyetdangky');
            Route::post('/duyethoso/{id}', 'duyetHoSo')->name('duyethoso');
            Route::post('/xacnhanthanhtoan-dangky/{id}', 'confirmPayment')->name('dangky.xacnhanthanhtoan');
            Route::post('/tuchoidangky/{id}', 'tuChoiDangKy')->name('xulytuchoidangky');
        });

        // Quản lý Hóa đơn & Công nợ
        Route::controller('HoadonController')->middleware('can:hoadon.manage')->group(function () {
            Route::get('/quanlyhoadon', 'lietKeHoaDonAdmin')->name('quanlyhoadon');
            Route::post('/xulyhoadon', 'xuLyHoaDon')->name('xulyhoadon');
            Route::post('/xacnhanthanhtoan/{id}', 'confirmPayment')->name('xacnhanthanhtoan');
            Route::get('/hoadon/{id}/pdf', 'downloadInvoicePDF')->name('hoadon.pdf');
        });
        Route::controller('CongnoController')->group(function () {
            Route::get('/baocaocongno', 'index')->name('baocaocongno');
            Route::post('/guinhacnho/{phongId}', 'update')->name('guinhacnho');
        });

        // Quản lý Bảo hỏng & Bảo trì
        Route::get('/quanlybaohong', 'BaohongController@lietKeBaoHongAdmin')->name('quanlybaohong');
        Route::post('/capnhatbaohong/{id}', 'BaohongController@capNhatBaoHong')->name('capnhatbaohong');
        Route::controller('LichsubaotriController')->group(function () {
            Route::get('/quanlybaotri', 'index')->name('quanlybaotri');
            Route::post('/thembaotri', 'store')->name('thembaotri');
            Route::post('/suabaotri/{id}', 'update')->name('suabaotri');
            Route::post('/xoabaotri/{id}', 'destroy')->name('xoabaotri');
            Route::post('/hoanthanhbaotri/{id}', 'hoanThanh')->name('hoanthanhbaotri');
        });
        Route::post('/vattu/{id}/baotri', 'LichsubaotriController@store')->name('vattu.baotri');

        // Quản lý Kỷ luật
        Route::controller('KyluatController')->middleware('can:kyluat.manage')->group(function () {
            Route::get('/quanlykyluat', 'lietKeKyLuatAdmin')->name('quanlykyluat');
            Route::post('/them/kyluat', 'storeDiscipline')->name('themkyluat');
            Route::post('/capnhat/kyluat/{id}', 'updateDiscipline')->name('capnhatkyluat');
        });

        // Đánh giá & Phản hồi
        Route::get('/quanlyphong/{id}/danhgia', 'DanhgiaController@listReviews')->name('phong.danhgia');

        // Cấu hình & Thông báo
        Route::get('/quanlycauhinh', 'CauhinhController@index')->middleware('can:cauhinh.manage')->name('quanlycauhinh');
        Route::post('/quanlycauhinh', 'CauhinhController@update')->middleware('can:cauhinh.manage')->name('capnhatcauhinh');
        
        Route::controller('ThongbaoController')->group(function () {
            Route::get('/quanlythongbao', 'index')->name('quanlythongbao');
            Route::post('/quanlythongbao', 'store')->name('themthongbao');
            Route::post('/quanlythongbao/xoa/{id}', 'destroy')->whereNumber('id')->name('xoathongbao');
            Route::post('/quanlythongbao/{id}', 'update')->whereNumber('id')->name('capnhatthongbao');
        });

        Route::get('/quanlylienhe', 'LienheController@index')->name('quanlylienhe');
        Route::post('/quanlylienhe/{id}/trangthai', 'LienheController@update')->whereNumber('id')->name('capnhattrangthailienhe');

        // Quản lý Hợp đồng
        Route::controller('HopdongController')->middleware('can:hopdong.manage')->group(function () {
            Route::get('/quanlyhopdong', 'index')->name('quanlyhopdong');
            Route::post('/taohopdong', 'store')->name('taohopdong');
            Route::post('/hopdong/{id}/giahan', 'extend')->name('hopdong.giahan');
            Route::post('/hopdong/{id}/thanhly', 'destroy')->name('hopdong.thanhly');
            Route::get('/hopdong/{id}/pdf', 'downloadPDF')->name('hopdong.pdf');
        });
    });

// --------------------------------------------------------------------------
// 3. STUDENT ROUTES
// --------------------------------------------------------------------------
Route::prefix('student')
    ->middleware(['auth', 'kiemtravaitro:sinhvien'])
    ->namespace('App\Http\Controllers\Student')
    ->name('student.')
    ->group(function () {
        
        Route::get('/trangchu', 'TrangchuController@index')->name('trangchu');

        // Phòng của tôi & Hóa đơn
        Route::get('/phongcuatoi', 'PhongCuaToiController@index')->name('phongcuatoi');
        Route::controller('HoadonController')->group(function () {
            Route::get('/hoadoncuaem', 'layHoaDonSinhVien')->name('hoadoncuaem');
            Route::get('/phongcuatoi/hoadon', 'layHoaDonSinhVien')->name('phongcuatoi.hoadon');
            Route::get('/phongcuatoi/hoadon/{id}', 'layChiTietHoaDonSinhVien')->name('phongcuatoi.hoadon.chitiet');
            Route::post('/hoadon/{id}/xac-nhan-loi', 'confirmPenalty')->name('hoadon.confirm_penalty');
        });

        // Đăng ký & Chuyển phòng
        Route::get('/danhsachphong', 'PhongController@index')->name('danhsachphong');
        Route::controller('DangkyController')->group(function () {
            Route::post('/dangkyphong', 'luuDangKySinhVien')->name('dangkyphong');
            Route::post('/yeucautraphong', 'yeuCauTraPhong')->name('yeucautraphong');
            Route::post('/yeucaudoiphong', 'yeuCauDoiPhong')->name('yeucaudoiphong');
        });

        // Hợp đồng
        Route::get('/hopdongcuatoi', 'HopdongController@index')->name('hopdongcuatoi');

        // Bảo hỏng & Tài sản
        Route::get('/baohong', 'BaohongController@lietKeBaoHongSinhVien')->name('danhsachbaohong');
        Route::post('/baohong', 'BaohongController@luuBaoHong')->name('thembaohong');
        Route::redirect('/taisanphong', '/student/phongcuatoi')->name('taisanphong');

        // Kỷ luật & Đánh giá
        Route::get('/kyluatcuaem', 'KyluatController@lietKeKyLuatSinhVien')->name('kyluatcuaem');
        Route::get('/danhgia', 'DanhgiaController@showReviewForm')->name('danhgia');
        Route::post('/danhgia', 'DanhgiaController@storeReview')->name('themdanhgia');

        // Thông báo
        Route::controller('ThongbaoController')->group(function () {
            Route::get('/thongbao', 'index')->name('thongbao');
            Route::get('/thongbao/{id}', 'show')->name('chitietthongbao');
            Route::patch('/thongbao', function () {
                auth()->user()->unreadNotifications->markAsRead();
                return back()->with('success', 'Đã đánh dấu tất cả là đã đọc.');
            })->name('thongbao.markAllRead');
        });
    });

// --------------------------------------------------------------------------
// 4. SHARED & AUTH ROUTES
// --------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/private-files/{path}', [FileController::class, 'showPrivateFile'])
    ->where('path', '.*')
    ->middleware(['auth', 'kiemtravaitro:admin,admin_truong,admin_toanha,le_tan'])
    ->name('private.file');

// Trạm điều hướng trung gian
Route::get('/dieuhuong', function () {
    $vaitro = Auth::user()->vaitro;
    if (in_array($vaitro, ['admin', 'admin_truong', 'admin_toanha', 'le_tan'], true)) {
        return redirect()->route('admin.trangchu');
    }
    return redirect()->route('student.trangchu');
})->middleware(['auth'])->name('dieuhuong');

Route::get('/dashboard', function () {
    return redirect()->route('dieuhuong');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
