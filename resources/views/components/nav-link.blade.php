@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 py-4 text-sm font-medium text-brand-700 transition duration-150 ring-1 ring-brand-600'
            : 'inline-flex items-center px-1 py-4 text-sm font-medium text-[#606060] transition duration-150 hover:text-[#121212]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
