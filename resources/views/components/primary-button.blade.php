<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-pill bg-signal-blue px-5 py-2.5 text-sm font-semibold text-pure-white transition hover:bg-bright-blue focus:outline-none focus:ring-2 focus:ring-signal-blue focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50']) }}>
    {{ $slot }}
</button>
