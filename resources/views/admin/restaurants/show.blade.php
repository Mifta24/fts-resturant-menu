<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $restaurant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm rounded-md p-4">
                    {{ __('Status restoran diperbarui.') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Informasi') }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Slug') }}: /{{ $restaurant->slug }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Paket Aktif') }}: {{ $restaurant->activeSubscription?->package?->name ?? '-' }}</p>

                <form method="POST" action="{{ route('admin.restaurants.status', $restaurant) }}" class="mt-4 flex items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <select name="public_status" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        @foreach (['draft', 'published', 'inactive'] as $status)
                            <option value="{{ $status }}" @selected($restaurant->public_status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <x-secondary-button type="submit">{{ __('Simpan Status') }}</x-secondary-button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg divide-y divide-gray-100 dark:divide-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 p-6 pb-0">{{ __('Riwayat Langganan') }}</h3>
                @forelse ($restaurant->subscriptions as $subscription)
                    <div class="p-6 text-sm text-gray-600 dark:text-gray-400">
                        {{ $subscription->package->name ?? '-' }} &middot; {{ $subscription->status }} &middot; {{ $subscription->billing_cycle }}
                    </div>
                @empty
                    <div class="p-6 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada langganan.') }}</div>
                @endforelse
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg divide-y divide-gray-100 dark:divide-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 p-6 pb-0">{{ __('Riwayat Pembayaran') }}</h3>
                @forelse ($restaurant->payments as $payment)
                    <div class="p-6 text-sm text-gray-600 dark:text-gray-400">
                        Rp{{ number_format((float) $payment->amount, 0, ',', '.') }} &middot; {{ $payment->status }}
                    </div>
                @empty
                    <div class="p-6 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada pembayaran.') }}</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
