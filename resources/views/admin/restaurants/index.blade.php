<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Restoran') }}</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="overflow-x-auto rounded-card bg-pure-white shadow-ambient">
            <table class="min-w-full text-sm">
                <thead class="border-b border-mist text-left text-smoke">
                    <tr>
                        <th class="p-4 font-medium">{{ __('Nama') }}</th>
                        <th class="p-4 font-medium">{{ __('Paket') }}</th>
                        <th class="p-4 font-medium">{{ __('Status') }}</th>
                        <th class="p-4 font-medium">{{ __('Menu') }}</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mist">
                    @foreach ($restaurants as $restaurant)
                        <tr>
                            <td class="p-4 text-ink">{{ $restaurant->name }}</td>
                            <td class="p-4 text-smoke">{{ $restaurant->activeSubscription?->package?->name ?? '-' }}</td>
                            <td class="p-4">
                                <x-badge :color="$restaurant->public_status === 'published' ? 'green' : ($restaurant->public_status === 'inactive' ? 'red' : 'gray')">
                                    {{ ucfirst($restaurant->public_status) }}
                                </x-badge>
                            </td>
                            <td class="p-4 text-smoke">{{ $restaurant->menu_items_count }}</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.restaurants.show', $restaurant) }}" class="text-signal-blue hover:underline">{{ __('Detail') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $restaurants->links() }}
    </div>
</x-app-layout>
