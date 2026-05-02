<?php

namespace App\Contracts\Shared;

use Illuminate\Http\Request;

interface ThongbaoServiceInterface
{
    public function indexForStudent(Request $yeuCau): array;

    public function showForStudent(int $id): array;

    public function indexForAdmin(): array;

    public function store(array $duLieu): array;

    public function update(int $id, array $duLieu): array;

    public function destroy(int $id): array;
}

