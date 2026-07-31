@props(['color' => 'gray'])

@php
$colors = [
    'green' => 'bg-vivid-green/15 text-green-700',
    'red' => 'bg-alert-red/15 text-red-700',
    'blue' => 'bg-signal-blue/15 text-blue-700',
    'amber' => 'bg-honey-glow/20 text-amber-800',
    'magenta' => 'bg-electric-magenta/15 text-fuchsia-700',
    'gray' => 'bg-mist text-smoke',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-pill px-3 py-1 text-xs font-medium ' . ($colors[$color] ?? $colors['gray'])]) }}>
    {{ $slot }}
</span>
