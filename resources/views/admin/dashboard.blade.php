<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Admin Dashboard') }}</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Total Restoran') }}</div>
                <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $totalRestaurants }}</div>
            </div>
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Langganan Aktif') }}</div>
                <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $activeSubscriptions }}</div>
            </div>
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Pembayaran Menunggu') }}</div>
                <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $pendingPayments }}</div>
            </div>
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Estimasi MRR') }}</div>
                <div class="mt-1 text-heading-sm font-semibold text-ink">Rp{{ number_format($estimatedMonthlyRevenue, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <x-secondary-button onclick="window.location='{{ route('admin.restaurants.index') }}'">{{ __('Kelola Restoran') }}</x-secondary-button>
            <x-secondary-button onclick="window.location='{{ route('admin.packages.index') }}'">{{ __('Kelola Paket') }}</x-secondary-button>
            <x-secondary-button onclick="window.location='{{ route('admin.subscriptions.index') }}'">{{ __('Kelola Langganan') }}</x-secondary-button>
            <x-secondary-button onclick="window.location='{{ route('admin.payments.index') }}'">{{ __('Kelola Pembayaran') }}</x-secondary-button>
            <x-secondary-button onclick="window.location='{{ route('admin.feedback.index') }}'">{{ __('Kelola Feedback') }}</x-secondary-button>
        </div>
    </div>
</x-app-layout>
