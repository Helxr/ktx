<button {{ $attributes->merge(['type' => 'submit', 'class' => 'linear-btn-primary']) }}>
    {{ $slot }}
</button>
