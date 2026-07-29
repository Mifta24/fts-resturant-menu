<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (! $hasStatistics)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center space-y-3">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">{{ __('Statistik belum tersedia di paket Anda') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Upgrade ke paket Business atau Pro untuk melihat jumlah kunjungan menu Anda.') }}</p>
                    <x-secondary-button onclick="window.location='{{ route('dashboard.subscription.show') }}'">{{ __('Lihat Paket') }}</x-secondary-button>
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Kunjungan Hari Ini') }}</div>
                        <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $viewsToday }}</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('7 Hari Terakhir') }}</div>
                        <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $viewsLast7Days }}</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('30 Hari Terakhir') }}</div>
                        <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $viewsLast30Days }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">{{ __('Kunjungan 14 Hari Terakhir') }}</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Total sepanjang waktu') }}: {{ $totalViews }}</span>
                    </div>
                    <div class="space-y-2">
                        @php $maxDaily = max([1, ...$dailyViews->values()->all()]); @endphp
                        @forelse ($dailyViews as $date => $total)
                            <div class="flex items-center gap-3 text-sm">
                                <span class="w-24 text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('d M') }}</span>
                                <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded h-3 overflow-hidden">
                                    <div class="bg-blue-500 h-3" style="width: {{ (int) round($total / $maxDaily * 100) }}%"></div>
                                </div>
                                <span class="w-8 text-right text-gray-700 dark:text-gray-300">{{ $total }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada kunjungan yang tercatat.') }}</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
