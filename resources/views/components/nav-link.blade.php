@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 rounded-xl bg-ink px-3 py-2.5 text-body font-semibold text-pure-white transition'
            : 'flex items-center gap-3 rounded-xl px-3 py-2.5 text-body font-medium text-smoke transition hover:bg-snow-gray hover:text-ink';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
