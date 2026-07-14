@props(['href'])

<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-left text-sm transition', 'href' => $href]) }}>
    {{ $slot }}
</a>
