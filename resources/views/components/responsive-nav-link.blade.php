@props(['active'])

@php
$classes = $active ?? false
    ? 'block w-full ps-3 pe-4 py-2 border-s-4 border-[#06b6d4] text-start text-base font-medium text-[#06b6d4] bg-[rgba(6,182,212,0.08)] transition'
    : 'block w-full ps-3 pe-4 py-2 border-s-4 border-transparent text-start text-base font-medium text-[#64748b] hover:text-[#f1f5f9] hover:bg-[rgba(255,255,255,0.04)] hover:border-[#334155] transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
