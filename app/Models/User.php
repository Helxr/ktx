<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_ADMIN_TRUONG = 'admin_truong';
    public const ROLE_ADMIN_TOA_NHA = 'admin_toanha';
    public const ROLE_LE_TAN = 'le_tan';
    public const ROLE_SINH_VIEN = 'sinhvien';
    public const ROLE_EX_STUDENT = 'cuu_sinhvien';

    /**
     * Chuyển sinh viên sang trạng thái Cựu sinh viên (Read-only access)
     */
    public function moveToExStudent(): bool
    {
        return $this->update([
            'vaitro' => self::ROLE_EX_STUDENT,
            'is_active' => true // Still active to allow login
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vaitro',
        'gioitinh',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Mối quan hệ 1-1 với bảng sinhvien
     */
    public function sinhvien()
    {
        return $this->hasOne(Sinhvien::class, 'user_id');
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->vaitro, $roles, true);
    }

    public function isAdminGroup(): bool
    {
        return $this->hasAnyRole([
            self::ROLE_ADMIN,
            self::ROLE_ADMIN_TRUONG,
            self::ROLE_ADMIN_TOA_NHA,
            self::ROLE_LE_TAN,
        ]);
    }

    /**
     * Vô hiệu hóa tài khoản sinh viên khi offboarding.
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }
}
