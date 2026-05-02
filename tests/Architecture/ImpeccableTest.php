<?php

namespace Tests\Architecture;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use Tests\TestCase;

class ImpeccableTest extends TestCase
{
    /**
     * RULE 1: Controller khong duoc goi Model truc tiep.
     */
    public function test_controllers_should_not_use_models_directly()
    {
        $danhSachController = $this->getProjectClassesInNamespace('App\\Http\\Controllers');
        $this->assertNotEmpty($danhSachController, 'Khong tim thay controller de kiem tra kien truc.');

        $soLuongDaKiemTra = 0;

        foreach ($danhSachController as $tenController) {
            if ($tenController === 'App\\Http\\Controllers\\Controller') {
                continue;
            }

            if (str_starts_with($tenController, 'App\\Http\\Controllers\\Auth')) {
                continue;
            }

            $duongDanFile = (new ReflectionClass($tenController))->getFileName();
            $noiDung = file_get_contents($duongDanFile);
            $soLuongDaKiemTra++;

            $this->assertStringNotContainsString(
                'use App\\Models',
                $noiDung,
                "Loi Kien Truc: Controller [{$tenController}] dang goi Model truc tiep. Hay chuyen logic sang Service."
            );
        }

        $this->assertGreaterThan(0, $soLuongDaKiemTra, 'Khong co controller hop le de thuc hien assert.');
    }

    /**
     * RULE 6 & 7: Chuan hoa naming suffix.
     */
    public function test_naming_conventions()
    {
        $services = $this->getProjectClassesInNamespace('App\\Services');
        foreach ($services as $service) {
            $this->assertStringEndsWith('Service', $service, "Loi: Service [{$service}] thieu hau to 'Service'.");
        }

        $contracts = $this->getProjectClassesInNamespace('App\\Contracts');
        foreach ($contracts as $contract) {
            if (interface_exists($contract)) {
                $this->assertStringEndsWith('Interface', $contract, "Loi: Interface [{$contract}] thieu hau to 'Interface'.");
            }
        }
    }

    /**
     * RULE 3: Moi Service phai implement it nhat 1 Interface.
     */
    public function test_every_service_must_implement_an_interface()
    {
        $services = $this->getProjectClassesInNamespace('App\\Services');

        foreach ($services as $service) {
            $reflection = new ReflectionClass($service);
            if ($reflection->isAbstract() || $reflection->isTrait()) {
                continue;
            }

            $interfaces = $reflection->getInterfaceNames();
            $this->assertNotEmpty($interfaces, "Loi Kien Truc: Service [{$service}] chua implement bat ky Interface nao.");
        }
    }

    /**
     * RULE 4 & 5: Gioi han do dai class va method.
     */
    public function test_classes_and_methods_should_not_be_too_long()
    {
        $namespaces = ['App\\Http\\Controllers', 'App\\Services'];

        foreach ($namespaces as $namespace) {
            $classes = $this->getProjectClassesInNamespace($namespace);

            foreach ($classes as $class) {
                $reflection = new ReflectionClass($class);
                $fileName = $reflection->getFileName();

                if ($fileName && file_exists($fileName)) {
                    $lines = count(file($fileName));
                    $limit = in_array($class, ['App\Services\Admin\DangkyService', 'App\Services\Admin\HopdongService'], true) ? 500 : 400;
                    $this->assertLessThanOrEqual($limit, $lines, "Loi: Class [{$class}] qua dai ({$lines} dong).");

                    foreach ($reflection->getMethods() as $method) {
                        if ($method->getDeclaringClass()->getName() === $class) {
                            $methodLength = $method->getEndLine() - $method->getStartLine() + 1;
                            $this->assertLessThanOrEqual(50, $methodLength, "Loi: Method [{$method->getName()}] trong [{$class}] qua dai ({$methodLength} dong).");
                        }
                    }
                }
            }
        }
    }

    /**
     * HELPER: Lay danh sach class theo namespace.
     */
    private function getProjectClassesInNamespace(string $namespace): array
    {
        $classes = [];
        $relativePath = str_replace('App\\', 'app\\', $namespace);
        $path = base_path(str_replace('\\', '/', $relativePath));

        if (! is_dir($path)) {
            return [];
        }

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $relativePath = str_replace(str_replace('\\', '/', $path) . '/', '', str_replace('\\', '/', $file->getPathname()));
                $className = $namespace . '\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

                if (class_exists($className) || interface_exists($className)) {
                    $classes[] = $className;
                }
            }
        }

        return $classes;
    }
}