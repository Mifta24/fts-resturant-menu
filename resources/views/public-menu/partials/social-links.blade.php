@if ($restaurant->whatsapp || $restaurant->instagram_url || $restaurant->maps_url)
    <div class="flex flex-wrap gap-2 mt-3">
        @if ($restaurant->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $restaurant->whatsapp) }}" target="_blank" rel="noopener" class="text-xs font-medium px-3 py-1.5 rounded-full bg-green-100 text-green-700">
                {{ __('WhatsApp') }}
            </a>
        @endif
        @if ($restaurant->instagram_url)
            <a href="{{ $restaurant->instagram_url }}" target="_blank" rel="noopener" class="text-xs font-medium px-3 py-1.5 rounded-full bg-pink-100 text-pink-700">
                {{ __('Instagram') }}
            </a>
        @endif
        @if ($restaurant->maps_url)
            <a href="{{ $restaurant->maps_url }}" target="_blank" rel="noopener" class="text-xs font-medium px-3 py-1.5 rounded-full bg-blue-100 text-blue-700">
                {{ __('Lokasi') }}
            </a>
        @endif
    </div>
@endif
