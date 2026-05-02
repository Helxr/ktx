<?php

namespace App\Contracts\Shared;

interface TaiSanPhongServiceInterface
{
    public function store(array $data, int $phongId): array;

    public function update(array $data, int $phongId, int $taisanId): array;

    public function destroy(int $phongId, int $taisanId): array;
}

