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


    /**
     * Chuyển sinh viên sang trạng thái Cựu sinh viên (Read-only access)
     */
    public function moveToExStudent(): bool
    {
        return $this->update([
            'vaitro' => \App\Enums\UserRole::CuuSinhVien,
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
        'vaitro' => \App\Enums\UserRole::class,
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
        $currentRole = $this->vaitro instanceof \App\Enums\UserRole 
            ? $this->vaitro->value 
            : (string) $this->vaitro;

        return collect($roles)->map(fn($role) => $role instanceof \App\Enums\UserRole ? $role->value : (string)$role)
            ->contains($currentRole);
    }

    public function isAdminGroup(): bool
    {
        $role = $this->vaitro;
        if ($role instanceof \App\Enums\UserRole) {
            return $role->isAdminGroup();
        }
        
        return in_array((string)$role, ['admin', 'admin_truong', 'admin_toanha', 'le_tan'], true);
    }

    /**
     * Vô hiệu hóa tài khoản sinh viên khi offboarding.
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }
}
