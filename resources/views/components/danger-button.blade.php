<button {{ $attributes->merge(['type' => 'submit', 'class' => 'linear-btn-danger']) }}>
    {{ $slot }}
</button>
