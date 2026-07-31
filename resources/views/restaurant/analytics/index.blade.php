<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Statistik') }}</h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">

        @if (! $hasStatistics)
            <div class="space-y-3 rounded-card bg-pure-white p-6 text-center shadow-ambient">
                <h2 class="font-semibold text-ink">{{ __('Statistik belum tersedia di paket Anda') }}</h2>
                <p class="text-sm text-smoke">{{ __('Upgrade ke paket Business atau Pro untuk melihat jumlah kunjungan menu Anda.') }}</p>
                <x-secondary-button onclick="window.location='{{ route('dashboard.subscription.show') }}'">{{ __('Lihat Paket') }}</x-secondary-button>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                    <div class="text-sm text-smoke">{{ __('Kunjungan Hari Ini') }}</div>
                    <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $viewsToday }}</div>
                </div>
                <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                    <div class="text-sm text-smoke">{{ __('7 Hari Terakhir') }}</div>
                    <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $viewsLast7Days }}</div>
                </div>
                <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                    <div class="text-sm text-smoke">{{ __('30 Hari Terakhir') }}</div>
                    <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $viewsLast30Days }}</div>
                </div>
            </div>

            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-semibold text-ink">{{ __('Kunjungan 14 Hari Terakhir') }}</h2>
                    <span class="text-sm text-smoke">{{ __('Total sepanjang waktu') }}: {{ $totalViews }}</span>
                </div>
                <div class="space-y-2">
                    @php $maxDaily = max([1, ...$dailyViews->values()->all()]); @endphp
                    @forelse ($dailyViews as $date => $total)
                        <div class="flex items-center gap-3 text-sm">
                            <span class="w-24 text-smoke">{{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('d M') }}</span>
                            <div class="h-3 flex-1 overflow-hidden rounded-full bg-snow-gray">
                                <div class="h-3 rounded-full bg-signal-blue" style="width: {{ (int) round($total / $maxDaily * 100) }}%"></div>
                            </div>
                            <span class="w-8 text-right text-ink">{{ $total }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-smoke">{{ __('Belum ada kunjungan yang tercatat.') }}</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
