<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $type;
    public $text;

    public function __construct($type = 'default', $text = null)
    {
        $this->type = $type;
        $this->text = $text ?: ucfirst($type);
    }

    public static function renderDirect($type = 'default', $text = null)
    {
        $text = $text ?? ucfirst(trim($type, "'\" "));

        $classes = self::resolveBadgeClass(trim($type, "'\" "));

        return '<span class="'.e($classes).'">'.e($text).'</span>';
    }

    protected static function resolveBadgeClass($type)
    {
        return match ($type) {
            'success' => 'inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800',
            'warning' => 'inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800',
            'danger' => 'inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-800',
            'info' => 'inline-flex items-center rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-800',
            default => 'inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700',
        };
    }

    public function render()
    {
        return view('components.badge');
    }
}
