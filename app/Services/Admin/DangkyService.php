<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\RegistrationStatus;
use App\Enums\RegistrationType;
use App\Events\GiuongStatusChanged;
use App\Contracts\Admin\DangkyServiceInterface;
use App\Mail\DangkyDaDuyetMail;
use App\Mail\DangkyKhachThanhCongMail;
use App\Models\Dangky;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use App\Traits\HoTroNghiepVu;
use App\Traits\PhanHoiService;
use App\Traits\KiemtraKyluat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DangkyService implements DangkyServiceInterface
{
    use HoTroNghiepVu, PhanHoiService, KiemtraKyluat;

    private const MESSAGE_ROOM_CONFLICT = 'Phòng đã đầy hoặc đang có người khác đăng ký, vui lòng thử lại.';

    public function luuDangKySinhVien(array $data): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (!$sinhvien) return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');

            $ketQuaKyluat = $this->kiemTraKyluat($sinhvien->id);
            if ($ketQuaKyluat['bi_chan']) return $this->traVeLoi($ketQuaKyluat['ly_do']);

            return DB::transaction(function () use ($data, $sinhvien) {
                if ($sinhvien->phong_id) return $this->traVeLoi('Bạn đã được xếp phòng.');

                $phong = Phong::where('id', (int)$data['phong_id'])->lockForUpdate()->first();
                if (!$phong) return $this->traVeLoi('Phòng không tồn tại.');

                if (Sinhvien::where('phong_id', $phong->id)->count() >= (int)$phong->succhuamax) {
                    return $this->traVeLoi(self::MESSAGE_ROOM_CONFLICT);
                }

                if (Dangky::where('sinhvien_id', $sinhvien->id)->where('trangthai', RegistrationStatus::Pending->value)->exists()) {
                    return $this->traVeLoi('Bạn đã gửi đăng ký, vui lòng chờ admin xử lý.');
                }

                Dangky::create([
                    'sinhvien_id' => $sinhvien->id,
                    'phong_id' => $phong->id,
                    'loaidangky' => RegistrationType::Rental->value,
                    'trangthai' => RegistrationStatus::Pending->value,
                ]);

                return $this->traVeThanhCong('Gửi đăng ký phòng thành công.');
            });
        } catch (\Throwable $e) {
            Log::error("Student registration failed: " . $e->getMessage());
            return $this->traVeLoi('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function yeuCauTraPhong(): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (!$sinhvien || !$sinhvien->phong_id) return $this->traVeLoi('Bạn hiện không có phòng để trả.');

            $coHoaDonChuaThanhToan = Hoadon::where('phong_id', $sinhvien->phong_id)
                ->where('trangthaithanhtoan', InvoiceStatus::Pending->value)
                ->exists();
            if ($coHoaDonChuaThanhToan) return $this->traVeLoi('Bạn còn hóa đơn chưa thanh toán.');

            if (Dangky::where('sinhvien_id', $sinhvien->id)
                ->where('trangthai', RegistrationStatus::Pending->value)
                ->where('loaidangky', RegistrationType::Return->value)
                ->exists()) {
                return $this->traVeLoi('Bạn đã gửi yêu cầu trả phòng.');
            }

            Dangky::create([
                'sinhvien_id' => $sinhvien->id,
                'phong_id' => $sinhvien->phong_id,
                'loaidangky' => RegistrationType::Return->value,
                'trangthai' => RegistrationStatus::Pending->value,
            ]);

            return $this->traVeThanhCong('Gửi yêu cầu trả phòng thành công.');
        } catch (\Throwable $e) {
            Log::error("Leave room request failed: " . $e->getMessage());
            return $this->traVeLoi('Có lỗi xảy ra.');
        }
    }

    public function yeuCauDoiPhong(array $data): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (!$sinhvien || !$sinhvien->phong_id) return $this->traVeLoi('Bạn hiện không có phòng để đổi.');

            $ketQuaKyluat = $this->kiemTraKyluat($sinhvien->id);
            if ($ketQuaKyluat['bi_chan']) return $this->traVeLoi($ketQuaKyluat['ly_do']);

            if ((int)$sinhvien->phong_id === (int)$data['phong_moi_id']) return $this->traVeLoi('Phòng mới phải khác phòng hiện tại.');

            if (Dangky::where('sinhvien_id', $sinhvien->id)
                ->where('trangthai', RegistrationStatus::Pending->value)
                ->where('loaidangky', RegistrationType::Change->value)
                ->exists()) {
                return $this->traVeLoi('Bạn đã gửi yêu cầu đổi phòng.');
            }

            Dangky::create([
                'sinhvien_id' => $sinhvien->id,
                'phong_id' => (int)$data['phong_moi_id'],
                'loaidangky' => RegistrationType::Change->value,
                'trangthai' => RegistrationStatus::Pending->value,
                'ghichu' => $data['lydo'],
            ]);

            return $this->traVeThanhCong('Gửi yêu cầu đổi phòng thành công.');
        } catch (\Throwable $e) {
            Log::error("Room change request failed: " . $e->getMessage());
            return $this->traVeLoi('Có lỗi xảy ra.');
        }
    }

    public function lietKeDangKyAdmin(Request $request): array
    {
        $status = $request->query('status', 'Tất cả');
        
        $registrations = Dangky::with(['sinhvien.taikhoan', 'phong'])
            ->when($status && $status !== 'Tất cả', fn($q) => $q->where('trangthai', $status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return [
            'danhsachdangky' => $registrations,
            'status' => $status,
        ];
    }

    public function duyetDangKy(int $id, ?string $ngayHetHan = null): array
    {
        try {
            $approvalData = DB::transaction(function () use ($id, $ngayHetHan) {
                $dangky = Dangky::with(['sinhvien.taikhoan', 'phong'])->where('id', $id)->lockForUpdate()->first();
                if (!$dangky) throw new \Exception('Không tìm thấy đăng ký.');
                if ($dangky->trangthai !== RegistrationStatus::Pending->value) throw new \Exception('Đăng ký này đã được xử lý.');

                $sinhvien = $dangky->sinhvien;
                $phong = $dangky->phong;

                if ($dangky->loaidangky === RegistrationType::Return->value) {
                    return $this->approveLeaveRoomLogic($dangky, $sinhvien);
                }

                $ngayBatDau = now()->format('Y-m-d');
                $ngayKetThuc = $ngayHetHan ?? now()->addMonths(5)->format('Y-m-d');

                if ($dangky->loaidangky === RegistrationType::Rental->value && $sinhvien?->phong_id) throw new \Exception('Sinh viên đã có phòng.');

                if (Sinhvien::where('phong_id', $phong->id)->count() >= (int)$phong->succhuamax) throw new \Exception(self::MESSAGE_ROOM_CONFLICT);

                $dangky->transitionTo(RegistrationStatus::Approved->value);

                if ($dangky->loaidangky === RegistrationType::Change->value && $sinhvien?->phong_id) {
                    $this->chamDutHopDongHienTai($sinhvien->id);
                }

                $sinhvien->update(['phong_id' => $phong->id, 'ngay_vao' => $ngayBatDau, 'ngay_het_han' => $ngayKetThuc]);

                $hopdong = Hopdong::create([
                    'sinhvien_id' => $sinhvien->id, 'phong_id' => $phong->id,
                    'ngay_bat_dau' => $ngayBatDau, 'ngay_ket_thuc' => $ngayKetThuc,
                    'giaphong_luc_ky' => (int)$phong->giaphong, 'trang_thai' => ContractStatus::Active->value,
                ]);

                $invoiceService = app(\App\Services\Admin\HoadonService::class);
                $invoiceService->taoHoaDonTheChan($sinhvien);
                $hoadon = $invoiceService->taoHoaDonHangThang($sinhvien, (int)now()->month, (int)now()->year, $ngayBatDau);

                return ['sinhvien' => $sinhvien, 'phong' => $phong, 'hopdong' => $hopdong, 'hoadon' => $hoadon, 'id' => $id];
            });

            $this->notifyApproval($approvalData);
            return $this->traVeThanhCong('Duyệt đăng ký thành công.');
        } catch (\Throwable $e) {
            Log::error("Approval failed: " . $e->getMessage());
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function tuChoiDangKy(int $id, ?string $reason): array
    {
        try {
            $dangky = Dangky::find($id);
            if (!$dangky) return $this->traVeLoi('Không tìm thấy đăng ký.');

            if (!$dangky->transitionTo(RegistrationStatus::Rejected->value, $reason)) return $this->traVeLoi('Không thể từ chối ở trạng thái hiện tại.');

            if ($dangky->phong_id && $dangky->giuong_no) {
                Event::dispatch(new GiuongStatusChanged((int)$dangky->phong_id, (int)$dangky->giuong_no, BedStatus::Available, BedStatus::Pending, 'Rejected'));
            }

            return $this->traVeThanhCong('Từ chối thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function duyetHoSo(int $id): array
    {
        try {
            $dangky = DB::transaction(function () use ($id) {
                $dk = Dangky::where('id', $id)->lockForUpdate()->first();
                if (!$dk || $dk->trangthai !== RegistrationStatus::Pending->value) throw new \Exception('Không hợp lệ.');
                $dk->transitionTo(RegistrationStatus::ApprovedPendingPayment->value);
                return $dk;
            });

            Mail::to($dangky->email)->queue(new \App\Mail\PaymentRequestMail($dangky));
            return $this->traVeThanhCong('Duyệt hồ sơ thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function xacNhanThanhToan(int $id): array
    {
        try {
            DB::transaction(function () use ($id) {
                $dangky = Dangky::where('id', $id)->lockForUpdate()->first();
                if (!$dangky || $dangky->trangthai !== RegistrationStatus::ApprovedPendingPayment->value) throw new \Exception('Không hợp lệ.');

                // Tạo User
                $user = $this->taoUserTuDangKy($dangky);

                // Di chuyển file từ private/dangky/ sang private/sinhvien/
                $filePaths = $this->diChuyenFileDangKySangSinhvien($dangky);

                // Tạo Sinhvien với dữ liệu PII đã bọc giáp (blind_index tự động tạo qua boot())
                $sinhvien = $this->taoSinhvienTuDangKy($user, $dangky);

                // Tạo Hopdong
                $hopdong = $this->taoHopdongChoSinhvien($sinhvien, $dangky);

                // Cập nhật Dangky
                $dangky->update([
                    'trangthai' => RegistrationStatus::Completed->value,
                    'sinhvien_id' => $sinhvien->id
                ]);

                // Dispatch event cho giường
                if ($dangky->giuong_no) {
                    Event::dispatch(new GiuongStatusChanged(
                        (int)$dangky->phong_id,
                        (int)$dangky->giuong_no,
                        BedStatus::Occupied,
                        BedStatus::Pending,
                        'Payment confirmed'
                    ));
                }
            });
            return $this->traVeThanhCong('Xác nhận thanh toán thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function luuDangkyKhach(array $data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                $phong = Phong::where('id', (int)$data['phong_id'])->lockForUpdate()->first();
                if (!$phong) return $this->traVeLoi('Phòng không tồn tại.');

                if ($phong->dang_o >= $phong->succhua) {
                    return $this->traVeLoi('Phòng đã đầy.');
                }

                $filePaths = $this->luuAnhDangKy($data);
                $lookupToken = Str::random(32);
                $dangky = Dangky::create([
                    'ho_ten' => $data['ho_ten'],
                    'ngay_sinh' => $data['ngay_sinh'],
                    'email' => $data['email'],
                    'so_dien_thoai' => $data['so_dien_thoai'],
                    'truong_hoc' => $data['truong_hoc'],
                    'phong_id' => $data['phong_id'],
                    'anh_the_path' => $filePaths['anh_the'],
                    'anh_cccd_path' => $filePaths['anh_cccd'],
                    'trangthai' => RegistrationStatus::Pending->value,
                    'loaidangky' => RegistrationType::Rental->value,
                    'lookup_token' => $lookupToken,
                ]);

                $this->guiEmailThongBao($data, $phong, $lookupToken);

                return $this->traVeThanhCong('Đăng ký thành công. Token tra cứu: ' . $lookupToken);
            });
        } catch (\Throwable $e) {
            Log::error('Guest registration failed: ' . $e->getMessage());
            return $this->traVeLoi('Đăng ký thất bại. Vui lòng thử lại.');
        }
    }

    private function luuAnhDangKy(array $data): array
    {
        $anhThePath = null;
        $anhCccdPath = null;

        if (isset($data['anh_the']) && $data['anh_the'] instanceof \Illuminate\Http\UploadedFile) {
            $anhThePath = $data['anh_the']->store('private/dangky/anh-the', 'local');
        }

        if (isset($data['anh_cccd']) && $data['anh_cccd'] instanceof \Illuminate\Http\UploadedFile) {
            $anhCccdPath = $data['anh_cccd']->store('private/dangky/anh-cccd', 'local');
        }

        return ['anh_the' => $anhThePath, 'anh_cccd' => $anhCccdPath];
    }

    private function guiEmailThongBao(array $data, Phong $phong, string $lookupToken): void
    {
        $lookupUrl = route('guest.lookup', ['token' => $lookupToken]);
        Mail::to($data['email'])->queue(new DangkyKhachThanhCongMail(
            $data['ho_ten'],
            $phong->ten_phong ?? "Phòng {$phong->id}",
            $lookupToken,
            $lookupUrl
        ));
    }

    private function diChuyenFileDangKySangSinhvien(Dangky $dangky): array
    {
        $anhThePathSinhvien = null;
        $anhCccdPathSinhvien = null;

        if ($dangky->anh_the_path && Storage::disk('private')->exists($dangky->anh_the_path)) {
            $anhThePathSinhvien = 'private/sinhvien/anh-the/' . basename($dangky->anh_the_path);
            Storage::disk('private')->move($dangky->anh_the_path, $anhThePathSinhvien);
        }

        if ($dangky->anh_cccd_path && Storage::disk('private')->exists($dangky->anh_cccd_path)) {
            $anhCccdPathSinhvien = 'private/sinhvien/anh-cccd/' . basename($dangky->anh_cccd_path);
            Storage::disk('private')->move($dangky->anh_cccd_path, $anhCccdPathSinhvien);
        }

        return ['anh_the' => $anhThePathSinhvien, 'anh_cccd' => $anhCccdPathSinhvien];
    }

    private function taoUserTuDangKy(Dangky $dangky): User
    {
        return User::create([
            'name' => $dangky->ho_ten,
            'email' => $dangky->email,
            'password' => bcrypt(Str::random(12)),
            'vaitro' => 'sinhvien',
            'is_active' => true
        ]);
    }

    private function taoSinhvienTuDangKy(User $user, Dangky $dangky): Sinhvien
    {
        return Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV' . str_pad((string)$user->id, 5, '0', STR_PAD_LEFT),
            'sodienthoai' => $dangky->so_dien_thoai,
            'so_cccd' => $dangky->so_cccd,
            'phong_id' => $dangky->phong_id,
            'giuong_no' => $dangky->giuong_no,
            'ngay_vao' => now()->format('Y-m-d'),
            'ngay_het_han' => now()->addMonths(5)->format('Y-m-d')
        ]);
    }

    private function taoHopdongChoSinhvien(Sinhvien $sinhvien, Dangky $dangky): Hopdong
    {
        return Hopdong::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $dangky->phong_id,
            'giuong_no' => $dangky->giuong_no,
            'ngay_bat_dau' => now()->format('Y-m-d'),
            'ngay_ket_thuc' => now()->addMonths(5)->format('Y-m-d'),
            'trang_thai' => ContractStatus::Active->value,
            'loai_hop_dong' => 'Thuê phòng'
        ]);
    }

    public function layDuLieuFormDangKyKhach(int $phongId, ?int $giuongNo = null): array
    {
        $phong = Phong::find($phongId);
        if (! $phong) {
            return $this->traVeLoi('Phòng bạn chọn không tồn tại.');
        }

        return [
            'success' => true,
            'phong' => $phong,
            'giuong_no' => $giuongNo,
        ];
    }

    public function layDuLieuTraCuuKhach(?string $token): array
    {
        $dangky = null;
        if ($token) {
            $dangky = Dangky::with('phong')
                ->where('lookup_token', $token)
                ->first();
        }

        return [
            'token' => $token,
            'dangky' => $dangky,
        ];
    }

    private function approveLeaveRoomLogic(Dangky $dangky, Sinhvien $sinhvien): array
    {
        $dangky->transitionTo(RegistrationStatus::Approved->value);
        $this->chamDutHopDongHienTai($sinhvien->id);
        $sinhvien->update(['phong_id' => null]);
        return ['is_leave_room' => true];
    }

    private function notifyApproval(array $data): void
    {
        if (isset($data['sinhvien']->taikhoan)) {
            Mail::to($data['sinhvien']->taikhoan->email)->queue(new DangkyDaDuyetMail($data['sinhvien'], $data['phong'], $data['hopdong'], $data['hoadon']));
        }
    }
}
