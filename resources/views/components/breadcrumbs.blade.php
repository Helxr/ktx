@php
    $segments = request()->segments();
    $currentPath = '';
@endphp

@if (count($segments) > 0)
    <nav class="linear-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ auth()->check() ? route('dieuhuong') : route('login') }}">Trang chủ</a>

        @foreach ($segments as $segment)
            @php
                $currentPath .= '/'.$segment;
                $label = \Illuminate\Support\Str::of($segment)->replace(['-', '_'], ' ')->title();
            @endphp

            <span>/</span>
            @if ($loop->last)
                <span class="font-semibold text-slate-900">{{ $label }}</span>
            @else
                <a href="{{ url($currentPath) }}">{{ $label }}</a>
            @endif
        @endforeach
    </nav>
@endif

