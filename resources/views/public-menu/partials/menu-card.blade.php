<div class="flex gap-3 bg-white rounded-lg shadow-sm p-3 {{ ! $item->is_available ? 'opacity-60' : '' }}">
    @if ($item->image_path)
        <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="h-16 w-16 rounded object-cover shrink-0">
    @else
        <div class="h-16 w-16 rounded bg-gray-100 shrink-0"></div>
    @endif

    <div class="min-w-0 flex-1">
        <div class="flex items-start justify-between gap-2">
            <h3 class="text-sm font-medium text-gray-900 truncate">{{ $item->name }}</h3>
            @unless ($item->is_available)
                <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 shrink-0">{{ __('Habis') }}</span>
            @endunless
        </div>
        @if ($item->description)
            <p class="text-xs text-gray-500 line-clamp-2 mt-0.5">{{ $item->description }}</p>
        @endif
        <p class="text-sm font-semibold text-gray-900 mt-1">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
    </div>
</div>
