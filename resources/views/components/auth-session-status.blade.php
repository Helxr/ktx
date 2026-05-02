@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-md border border-gray-200/70 bg-[#F7F7F8] px-3 py-2 text-sm font-medium text-[#606060]']) }}>
        {{ $status }}
    </div>
@endif
