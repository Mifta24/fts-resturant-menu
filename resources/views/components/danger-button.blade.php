<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-pill bg-alert-red px-5 py-2.5 text-sm font-semibold text-pure-white transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-alert-red focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50']) }}>
    {{ $slot }}
</button>
