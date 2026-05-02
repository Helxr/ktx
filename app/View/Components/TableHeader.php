<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableHeader extends Component
{
    public function render()
    {
        return <<<'blade'
        <thead class="bg-[#F7F7F8] text-xs uppercase text-[#606060]">
            {{ $slot }}
        </thead>
        blade;
    }
}
