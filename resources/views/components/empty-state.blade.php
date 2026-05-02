@props([
    'title' => 'Không có dữ liệu',
    'description' => 'Dữ liệu sẽ hiển thị tại đây khi có bản ghi mới.',
    'actionLabel' => null,
    'actionHref' => null,
])

<div {{ $attributes->merge(['class' => 'linear-empty']) }}>
    <div class="linear-skeleton h-14 w-14 rounded-2xl"></div>
    <h3 class="linear-empty-title">{{ $title }}</h3>
    <p class="linear-empty-subtitle">{{ $description }}</p>

    @if ($actionLabel && $actionHref)
        <a href="{{ $actionHref }}" class="linear-btn-primary mt-1">
            {{ $actionLabel }}
        </a>
    @endif
</div>
