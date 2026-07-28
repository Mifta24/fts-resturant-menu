<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Total Restoran') }}</div>
                    <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $totalRestaurants }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Langganan Aktif') }}</div>
                    <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $activeSubscriptions }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Pembayaran Menunggu') }}</div>
                    <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $pendingPayments }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Estimasi MRR') }}</div>
                    <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Rp{{ number_format($estimatedMonthlyRevenue, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <x-secondary-button onclick="window.location='{{ route('admin.restaurants.index') }}'">{{ __('Kelola Restoran') }}</x-secondary-button>
                <x-secondary-button onclick="window.location='{{ route('admin.packages.index') }}'">{{ __('Kelola Paket') }}</x-secondary-button>
                <x-secondary-button onclick="window.location='{{ route('admin.subscriptions.index') }}'">{{ __('Kelola Langganan') }}</x-secondary-button>
                <x-secondary-button onclick="window.location='{{ route('admin.payments.index') }}'">{{ __('Kelola Pembayaran') }}</x-secondary-button>
            </div>
        </div>
    </div>
</x-app-layout>
