<?php

namespace App\Contracts\Shared;

interface VatTuPhongServiceInterface
{
    public function store(array $data, int $phongId): array;

    public function update(array $data, int $phongId, int $vattuId): array;

    public function destroy(int $phongId, int $vattuId): array;
}

