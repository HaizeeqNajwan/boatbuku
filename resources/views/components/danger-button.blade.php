<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary', 'style' => 'color: var(--red); border-color: rgba(239, 68, 68, 0.3);']) }}>
    {{ $slot }}
</button>
