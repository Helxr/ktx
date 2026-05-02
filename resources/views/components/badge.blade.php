@props(['type' => 'default', 'text' => null, 'dot' => false])

@php
    $colorClass = match ($type) {
        'success' => 'linear-badge border-emerald-200 bg-emerald-50 text-emerald-700',
        'warning' => 'linear-badge linear-badge-pending border-amber-200 bg-amber-50 text-amber-700',
        'danger' => 'linear-badge border-rose-200 bg-rose-50 text-rose-700',
        'info' => 'linear-badge border-brand-200 bg-brand-50 text-brand-700',
        default => 'linear-badge',
    };

    $label = $text ?? ucfirst($type);
@endphp

<span {{ $attributes->merge(['class' => $colorClass]) }}>
    @if ($dot || $type === 'warning')
        <span class="linear-badge-dot" aria-hidden="true"></span>
    @endif
    {{ $label }}
</span>
