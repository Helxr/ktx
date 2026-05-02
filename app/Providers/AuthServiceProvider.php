<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register authentication and authorization services.
     */
    public function boot(): void
    {
        Gate::define('dangky.review', function (User $user): bool {
            return $user->hasAnyRole([
                User::ROLE_ADMIN,
                User::ROLE_ADMIN_TRUONG,
                User::ROLE_ADMIN_TOA_NHA,
                User::ROLE_LE_TAN,
            ]);
        });

        Gate::define('hopdong.manage', function (User $user): bool {
            return $user->hasAnyRole([
                User::ROLE_ADMIN,
                User::ROLE_ADMIN_TRUONG,
                User::ROLE_ADMIN_TOA_NHA,
            ]);
        });

        Gate::define('hoadon.manage', function (User $user): bool {
            return $user->hasAnyRole([
                User::ROLE_ADMIN,
                User::ROLE_ADMIN_TRUONG,
                User::ROLE_ADMIN_TOA_NHA,
                User::ROLE_LE_TAN,
            ]);
        });

        Gate::define('cauhinh.manage', function (User $user): bool {
            return $user->hasAnyRole([
                User::ROLE_ADMIN,
                User::ROLE_ADMIN_TRUONG,
            ]);
        });

        Gate::define('kyluat.manage', function (User $user): bool {
            return $user->hasAnyRole([
                User::ROLE_ADMIN,
                User::ROLE_ADMIN_TRUONG,
                User::ROLE_ADMIN_TOA_NHA,
            ]);
        });
    }
}
