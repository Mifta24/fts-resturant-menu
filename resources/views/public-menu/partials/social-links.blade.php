@if ($restaurant->whatsapp || $restaurant->instagram_url || $restaurant->maps_url || $restaurant->phone)
    <div class="mt-4 flex flex-wrap gap-2 border-t border-mist pt-4">
        @if ($restaurant->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $restaurant->whatsapp) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-pill bg-vivid-green/10 px-3 py-2 text-xs font-semibold text-vivid-green transition hover:bg-vivid-green/20">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a8 8 0 0 1-11.8 7L4 20l1.5-4.1A8 8 0 1 1 20 11.5Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.5c.5 2.5 2 4 4.5 5" />
                </svg>
                {{ __('WhatsApp') }}
            </a>
        @endif
        @if ($restaurant->instagram_url)
            <a href="{{ $restaurant->instagram_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-pill bg-electric-magenta/10 px-3 py-2 text-xs font-semibold text-electric-magenta transition hover:bg-electric-magenta/20">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <rect x="4" y="4" width="16" height="16" rx="5" />
                    <circle cx="12" cy="12" r="3.5" />
                    <circle cx="17.5" cy="6.5" r=".75" fill="currentColor" stroke="none" />
                </svg>
                {{ __('Instagram') }}
            </a>
        @endif
        @if ($restaurant->maps_url)
            <a href="{{ $restaurant->maps_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-pill bg-signal-blue/10 px-3 py-2 text-xs font-semibold text-signal-blue transition hover:bg-signal-blue/20">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                    <circle cx="12" cy="10" r="2.5" />
                </svg>
                {{ __('Lokasi') }}
            </a>
        @endif
        @if ($restaurant->phone)
            <a href="tel:{{ preg_replace('/[^\d+]/', '', $restaurant->phone) }}" class="inline-flex items-center gap-1.5 rounded-pill bg-snow-gray px-3 py-2 text-xs font-semibold text-smoke transition hover:bg-mist hover:text-ink">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5 10 8l-2 2c1.1 2.5 3 4.4 5.5 5.5l2-2 3.5 2.5v2c0 1.1-.9 2-2 2C9.8 20 4 14.2 4 7c0-1.1.9-2 2-2h1.5Z" />
                </svg>
                {{ __('Telepon') }}
            </a>
        @endif
    </div>
@endif
