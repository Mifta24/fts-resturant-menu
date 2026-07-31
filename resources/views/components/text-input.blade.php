@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border-silver text-ink placeholder-pewter shadow-sm focus:border-signal-blue focus:ring-signal-blue']) }}>
