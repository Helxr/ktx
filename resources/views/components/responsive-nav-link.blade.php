@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-md bg-brand-50 px-3 py-2 text-start text-sm font-medium text-brand-700 transition duration-150 ring-1 ring-brand-600'
            : 'block w-full rounded-md px-3 py-2 text-start text-sm font-medium text-[#606060] transition duration-150 hover:bg-[#F7F7F8] hover:text-[#121212]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
