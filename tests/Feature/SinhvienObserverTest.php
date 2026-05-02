<?php

namespace Tests\Feature;

use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SinhvienObserverTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Observer is automatically registered in AppServiceProvider
    }

    /**
     * Test gán phòng → dango tăng
     */
    public function test_assign_room_increases_dango()
    {
        // Tạo phòng với succhuamax = 4, dango = 0
        $phong = Phong::create([
            'tenphong' => 'A101',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        // Tạo user và sinh viên
        $user = User::create([
            'name' => 'Test Student',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV001',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
        ]);

        // Gán phòng cho sinh viên
        $sinhvien->update(['phong_id' => $phong->id]);

        // Refresh để lấy giá trị mới từ database
        $phong->refresh();

        // Verify dango tăng lên 1
        $this->assertEquals(1, $phong->dango);
    }

    /**
     * Test rời phòng → dango giảm
     */
    public function test_leave_room_decreases_dango()
    {
        // Tạo phòng với sinh viên đang ở
        $phong = Phong::create([
            'tenphong' => 'A102',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        $user = User::create([
            'name' => 'Test Student 2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV002',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
            'phong_id' => $phong->id,
        ]);

        $phong->refresh();
        $this->assertEquals(1, $phong->dango);

        // Rời phòng
        $sinhvien->update(['phong_id' => null]);

        $phong->refresh();

        // Verify dango giảm về 0
        $this->assertEquals(0, $phong->dango);
    }

    /**
     * Test chuyển phòng → dango phòng cũ giảm, phòng mới tăng
     */
    public function test_transfer_room_updates_both_rooms()
    {
        // Tạo 2 phòng
        $phongCu = Phong::create([
            'tenphong' => 'A103',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        $phongMoi = Phong::create([
            'tenphong' => 'A104',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        $user = User::create([
            'name' => 'Test Student 3',
            'email' => 'test3@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV003',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
            'phong_id' => $phongCu->id,
        ]);

        $phongCu->refresh();
        $phongMoi->refresh();
        $this->assertEquals(1, $phongCu->dango);
        $this->assertEquals(0, $phongMoi->dango);

        // Chuyển phòng
        $sinhvien->update(['phong_id' => $phongMoi->id]);

        $phongCu->refresh();
        $phongMoi->refresh();

        // Verify dango phòng cũ giảm về 0, phòng mới tăng lên 1
        $this->assertEquals(0, $phongCu->dango);
        $this->assertEquals(1, $phongMoi->dango);
    }

    /**
     * Test soft-delete → dango giảm
     */
    public function test_soft_delete_decreases_dango()
    {
        $phong = Phong::create([
            'tenphong' => 'A105',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        $user = User::create([
            'name' => 'Test Student 4',
            'email' => 'test4@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV004',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
            'phong_id' => $phong->id,
        ]);

        $phong->refresh();
        $this->assertEquals(1, $phong->dango);

        // Soft-delete sinh viên
        $sinhvien->delete();

        $phong->refresh();

        // Verify dango giảm về 0 (soft-deleted không được đếm)
        $this->assertEquals(0, $phong->dango);
    }

    /**
     * Test restore → dango tăng lại
     */
    public function test_restore_increases_dango()
    {
        $phong = Phong::create([
            'tenphong' => 'A106',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        $user = User::create([
            'name' => 'Test Student 5',
            'email' => 'test5@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV005',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
            'phong_id' => $phong->id,
        ]);

        $phong->refresh();
        $this->assertEquals(1, $phong->dango);

        // Soft-delete
        $sinhvien->delete();

        $phong->refresh();
        $this->assertEquals(0, $phong->dango);

        // Restore
        $sinhvien->restore();

        $phong->refresh();

        // Verify dango tăng lại lên 1
        $this->assertEquals(1, $phong->dango);
    }

    /**
     * Test tạo sinh viên với phòng ngay lập tức → dango tăng
     */
    public function test_create_student_with_room_increases_dango()
    {
        $phong = Phong::create([
            'tenphong' => 'A107',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        $user = User::create([
            'name' => 'Test Student 6',
            'email' => 'test6@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        // Tạo sinh viên với phong_id ngay từ đầu
        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV006',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
            'phong_id' => $phong->id,
        ]);

        $phong->refresh();

        // Verify dango tăng lên 1
        $this->assertEquals(1, $phong->dango);
    }

    /**
     * Test withoutTrashed() - soft-deleted sinh viên không được đếm
     */
    public function test_without_trashed_excludes_soft_deleted_students()
    {
        $phong = Phong::create([
            'tenphong' => 'A108',
            'tang' => 1,
            'soluongtoida' => 4,
            'succhuamax' => 4,
            'dango' => 0,
            'giaphong' => 1000000,
            'trangthai' => 'active',
        ]);

        // Tạo 2 sinh viên
        $user1 = User::create([
            'name' => 'Test Student 7',
            'email' => 'test7@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        $user2 = User::create([
            'name' => 'Test Student 8',
            'email' => 'test8@example.com',
            'password' => bcrypt('password'),
            'gioitinh' => 'nam',
        ]);

        $sinhvien1 = Sinhvien::create([
            'user_id' => $user1->id,
            'masinhvien' => 'SV007',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
            'phong_id' => $phong->id,
        ]);

        $sinhvien2 = Sinhvien::create([
            'user_id' => $user2->id,
            'masinhvien' => 'SV008',
            'lop' => 'CNTT-K15',
            'sodienthoai' => '0123456789',
            'phong_id' => $phong->id,
        ]);

        $phong->refresh();
        $this->assertEquals(2, $phong->dango);

        // Soft-delete 1 sinh viên
        $sinhvien1->delete();

        $phong->refresh();

        // Verify dango giảm về 1 (chỉ đếm sinh viên chưa soft-delete)
        $this->assertEquals(1, $phong->dango);
    }
}
