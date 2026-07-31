<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ $restaurant->name }}</h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">

        @if (session('status'))
            <div class="rounded-xl bg-vivid-green/15 p-4 text-sm text-green-700">
                {{ __('Status restoran diperbarui.') }}
            </div>
        @endif

        <div class="rounded-card bg-pure-white p-6 shadow-ambient">
            <h2 class="mb-2 font-semibold text-ink">{{ __('Informasi') }}</h2>
            <p class="text-sm text-smoke">{{ __('Slug') }}: /{{ $restaurant->slug }}</p>
            <p class="text-sm text-smoke">{{ __('Paket Aktif') }}: {{ $restaurant->activeSubscription?->package?->name ?? '-' }}</p>

            <form method="POST" action="{{ route('admin.restaurants.status', $restaurant) }}" class="mt-4 flex items-center gap-3">
                @csrf
                @method('PATCH')
                <select name="public_status" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
                    @foreach (['draft', 'published', 'inactive'] as $status)
                        <option value="{{ $status }}" @selected($restaurant->public_status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <x-secondary-button type="submit">{{ __('Simpan Status') }}</x-secondary-button>
            </form>
        </div>

        <div class="divide-y divide-mist rounded-card bg-pure-white shadow-ambient">
            <h2 class="p-6 pb-0 font-semibold text-ink">{{ __('Riwayat Langganan') }}</h2>
            @forelse ($restaurant->subscriptions as $subscription)
                <div class="p-6 text-sm text-smoke">
                    {{ $subscription->package->name ?? '-' }} &middot; {{ $subscription->status }} &middot; {{ $subscription->billing_cycle }}
                </div>
            @empty
                <div class="p-6 text-sm text-smoke">{{ __('Belum ada langganan.') }}</div>
            @endforelse
        </div>

        <div class="divide-y divide-mist rounded-card bg-pure-white shadow-ambient">
            <h2 class="p-6 pb-0 font-semibold text-ink">{{ __('Riwayat Pembayaran') }}</h2>
            @forelse ($restaurant->payments as $payment)
                <div class="p-6 text-sm text-smoke">
                    Rp{{ number_format((float) $payment->amount, 0, ',', '.') }} &middot; {{ $payment->status }}
                </div>
            @empty
                <div class="p-6 text-sm text-smoke">{{ __('Belum ada pembayaran.') }}</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
