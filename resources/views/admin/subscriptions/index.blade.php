<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Langganan') }}</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="overflow-x-auto rounded-card bg-pure-white shadow-ambient">
            <table class="min-w-full text-sm">
                <thead class="border-b border-mist text-left text-smoke">
                    <tr>
                        <th class="p-4 font-medium">{{ __('Restoran') }}</th>
                        <th class="p-4 font-medium">{{ __('Paket') }}</th>
                        <th class="p-4 font-medium">{{ __('Siklus') }}</th>
                        <th class="p-4 font-medium">{{ __('Berakhir') }}</th>
                        <th class="p-4 font-medium">{{ __('Status') }}</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mist">
                    @foreach ($subscriptions as $subscription)
                        <tr>
                            <td class="p-4 text-ink">{{ $subscription->restaurant->name }}</td>
                            <td class="p-4 text-smoke">{{ $subscription->package->name ?? '-' }}</td>
                            <td class="p-4 text-smoke">{{ $subscription->billing_cycle }}</td>
                            <td class="p-4 text-smoke">{{ $subscription->ends_at?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td class="p-4">
                                <x-badge :color="$subscription->status === 'active' ? 'green' : ($subscription->status === 'pending' ? 'amber' : ($subscription->status === 'cancelled' ? 'red' : 'gray'))">
                                    {{ $subscription->status }}
                                </x-badge>
                            </td>
                            <td class="p-4 text-right">
                                <form method="POST" action="{{ route('admin.subscriptions.update', $subscription) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
                                        @foreach (['pending', 'active', 'expired', 'cancelled'] as $status)
                                            <option value="{{ $status }}" @selected($subscription->status === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <x-secondary-button type="submit">{{ __('Simpan') }}</x-secondary-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $subscriptions->links() }}
    </div>
</x-app-layout>
