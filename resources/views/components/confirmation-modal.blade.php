@props([
    'title' => 'Xác nhận',
    'message' => 'Bạn có chắc chắn muốn thực hiện hành động này?',
    'confirmText' => 'Xác nhận',
    'cancelText' => 'Hủy',
    'type' => 'warning', // warning, danger, info
])

@php
$typeStyles = [
    'warning' => ['icon' => 'text-amber-500', 'bg' => 'bg-amber-50', 'button' => 'linear-btn-primary'],
    'danger' => ['icon' => 'text-red-500', 'bg' => 'bg-red-50', 'button' => 'linear-btn-danger'],
    'info' => ['icon' => 'text-blue-500', 'bg' => 'bg-blue-50', 'button' => 'linear-btn-primary'],
];
$style = $typeStyles[$type] ?? $typeStyles['warning'];
@endphp

<template x-teleport="body">
    <div
        x-show="showConfirm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="linear-modal-backdrop flex items-center justify-center p-4"
        @click.self="showConfirm = false"
        style="display: none;"
    >
        <div
            x-show="showConfirm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="linear-modal-card max-w-md w-full"
            @confirmed.window="if ($event.target === $el) { showConfirm = false; }"
        >
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full {{ $style['bg'] }} flex items-center justify-center">
                            <svg class="h-5 w-5 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($type === 'danger')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                @elseif($type === 'warning')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
                        <p class="mt-1 text-sm text-zinc-600">{{ $message }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        @click="showConfirm = false"
                        class="linear-btn-secondary"
                    >
                        {{ $cancelText }}
                    </button>
                    <button
                        type="button"
                        @click="$dispatch('confirmed'); showConfirm = false"
                        class="{{ $style['button'] }}"
                    >
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
