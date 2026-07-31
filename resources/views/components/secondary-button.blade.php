<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-pill border border-silver bg-pure-white px-5 py-2.5 text-sm font-semibold text-ink transition hover:border-ink disabled:cursor-not-allowed disabled:opacity-50']) }}>
    {{ $slot }}
</button>
