<article class="group flex min-h-28 gap-3 rounded-card border border-mist bg-pure-white p-3 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-ambient {{ ! $item->is_available ? 'opacity-60' : '' }}">
    @if ($item->image_source)
        <img src="{{ $item->image_source }}" alt="{{ $item->name }}" class="h-24 w-24 shrink-0 rounded-xl object-cover sm:h-28 sm:w-28" loading="lazy">
    @else
        <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-xl bg-snow-gray text-pewter sm:h-28 sm:w-28">
            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4zM4 16l4.5-4.5 3 3 2-2L20 19M15.5 8.5h.01" />
            </svg>
        </div>
    @endif

    <div class="flex min-w-0 flex-1 flex-col py-0.5">
        <div class="flex items-start justify-between gap-2">
            <h3 class="line-clamp-2 text-sm font-semibold leading-5 text-ink sm:text-body">{{ $item->name }}</h3>
            @unless ($item->is_available)
                <span class="shrink-0 rounded-pill bg-mist px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-smoke">{{ __('Habis') }}</span>
            @endunless
        </div>
        @if ($item->description)
            <p class="mt-1 line-clamp-2 text-xs leading-4 text-smoke">{{ $item->description }}</p>
        @endif
        <p class="mt-auto pt-2 text-sm font-bold text-ink">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
    </div>
</article>
