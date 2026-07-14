@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'session-success']) }}>
        {{ $status }}
    </div>
@endif
