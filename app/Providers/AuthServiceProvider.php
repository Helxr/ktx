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
                \App\Enums\UserRole::Admin,
                \App\Enums\UserRole::AdminTruong,
                \App\Enums\UserRole::AdminToaNha,
                \App\Enums\UserRole::LeTan,
            ]);
        });

        Gate::define('hopdong.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
                \App\Enums\UserRole::AdminTruong,
                \App\Enums\UserRole::AdminToaNha,
            ]);
        });

        Gate::define('hoadon.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
                \App\Enums\UserRole::AdminTruong,
                \App\Enums\UserRole::AdminToaNha,
                \App\Enums\UserRole::LeTan,
            ]);
        });

        Gate::define('cauhinh.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
                \App\Enums\UserRole::AdminTruong,
            ]);
        });

        Gate::define('kyluat.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
                \App\Enums\UserRole::AdminTruong,
                \App\Enums\UserRole::AdminToaNha,
            ]);
        });
    }
}
