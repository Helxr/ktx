<?php

namespace App\Providers;

use App\Contracts\Admin\DangkyServiceInterface;
use App\Contracts\Core\TienIchServiceInterface;
use App\Contracts\Core\KiemToanServiceInterface;
use App\Contracts\Student\BaohongServiceInterface;
use App\Contracts\Student\TraPhongServiceInterface;
use App\Contracts\Admin\BangDieuKhienServiceInterface;
use App\Contracts\Student\DanhgiaServiceInterface;
use App\Contracts\Admin\HoadonServiceInterface;
use App\Contracts\Core\TrangChuServiceInterface;
use App\Contracts\Student\KyluatServiceInterface;
use App\Contracts\Admin\TaiChinhServiceInterface;
use App\Contracts\Admin\BaoTriServiceInterface;
use App\Contracts\Core\TruyVanPhongServiceInterface;
use App\Contracts\Shared\NghiepVuPhongServiceInterface;
use App\Contracts\Shared\KhoPhongServiceInterface;
use App\Contracts\Shared\TaiSanPhongServiceInterface;
use App\Contracts\Shared\VatTuPhongServiceInterface;
use App\Contracts\Shared\ThongbaoServiceInterface;
use App\Contracts\Shared\SinhvienServiceInterface;
use App\Contracts\Student\PhongSinhvienServiceInterface;
use App\Contracts\Admin\HopdongServiceInterface;
use App\Repositories\PhongRepository;
use App\Repositories\SinhvienRepository;
use App\Services\Core\KiemToanService;
use App\Services\Student\BaohongService;
use App\Services\Student\TraPhongService;
use App\Services\Admin\BangDieuKhienService;
use App\Services\Student\DanhgiaService;
use App\Services\Admin\HoadonService;
use App\Services\Core\TrangChuService;
use App\Services\Student\KyluatService;
use App\Services\Admin\TaiChinhService;
use App\Services\Admin\BaoTriService;
use App\Services\Core\TruyVanPhongService;
use App\Services\Shared\NghiepVuPhongService;
use App\Services\Shared\KhoPhongService;
use App\Services\Shared\TaiSanPhongService;
use App\Services\Shared\VatTuPhongService;
use App\Services\Shared\ThongbaoService;
use App\Services\Shared\SinhvienService;
use App\Services\Student\PhongSinhvienService;
use App\Services\Core\TienIchService;
use App\Services\Admin\HopdongService;
use App\Services\Admin\DangkyService;
use App\Models\Baohong;
use App\Models\Cauhinh;
use App\Models\Danhgia;
use App\Models\Hopdong;
use App\Models\Hoadon;
use App\Models\Kyluat;
use App\Models\Lichsubaotri;
use App\Models\Lienhe;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Taisan;
use App\Models\Thongbao;
use App\Models\Vattu;
use App\Observers\BaohongObserver;
use App\Observers\CauhinhObserver;
use App\Observers\DanhgiaObserver;
use App\Observers\HopdongObserver;
use App\Observers\HoadonObserver;
use App\Observers\KyluatObserver;
use App\Observers\LichsubaotriObserver;
use App\Observers\LienheObserver;
use App\Observers\PhongObserver;
use App\Observers\SinhvienObserver;
use App\Observers\TaisanObserver;
use App\Observers\ThongbaoObserver;
use App\Observers\VattuObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\View\Components\Badge;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DangkyServiceInterface::class, DangkyService::class);
        $this->app->bind(HopdongServiceInterface::class, HopdongService::class);
        // Repository bindings
        $this->app->bind(KiemToanServiceInterface::class, KiemToanService::class);
        $this->app->bind(TraPhongServiceInterface::class, TraPhongService::class);
        $this->app->bind(TruyVanPhongServiceInterface::class, TruyVanPhongService::class);
        $this->app->bind(NghiepVuPhongServiceInterface::class, NghiepVuPhongService::class);
        $this->app->bind(KhoPhongServiceInterface::class, KhoPhongService::class);
        $this->app->bind(TaiSanPhongServiceInterface::class, TaiSanPhongService::class);
        $this->app->bind(VatTuPhongServiceInterface::class, VatTuPhongService::class);
        $this->app->bind(BaohongServiceInterface::class, BaohongService::class);
        $this->app->bind(HoadonServiceInterface::class, HoadonService::class);
        $this->app->bind(DanhgiaServiceInterface::class, DanhgiaService::class);
        $this->app->bind(SinhvienServiceInterface::class, SinhvienService::class);
        $this->app->bind(BangDieuKhienServiceInterface::class, BangDieuKhienService::class);
        $this->app->bind(PhongSinhvienServiceInterface::class, PhongSinhvienService::class);
        $this->app->bind(ThongbaoServiceInterface::class, ThongbaoService::class);
        $this->app->bind(TrangChuServiceInterface::class, TrangChuService::class);
        $this->app->bind(KyluatServiceInterface::class, KyluatService::class);
        $this->app->bind(TaiChinhServiceInterface::class, TaiChinhService::class);
        $this->app->bind(BaoTriServiceInterface::class, BaoTriService::class);
        $this->app->bind(TienIchServiceInterface::class, TienIchService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sinhvien::observe(SinhvienObserver::class);
        Hopdong::observe(HopdongObserver::class);
        Hoadon::observe(HoadonObserver::class);
        Phong::observe(PhongObserver::class);
        Taisan::observe(TaisanObserver::class);
        Vattu::observe(VattuObserver::class);
        Kyluat::observe(KyluatObserver::class);
        Danhgia::observe(DanhgiaObserver::class);
        Lichsubaotri::observe(LichsubaotriObserver::class);
        Lienhe::observe(LienheObserver::class);
        Cauhinh::observe(CauhinhObserver::class);
        Baohong::observe(BaohongObserver::class);
        Thongbao::observe(ThongbaoObserver::class);

        Blade::directive('badge', function ($expression) {
            return "<?php echo \App\View\Components\Badge::renderDirect($expression); ?>";
        });
    }
}
