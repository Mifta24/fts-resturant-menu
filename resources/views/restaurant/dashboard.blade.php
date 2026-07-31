<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Dashboard') }}</h1>
        <p class="mt-1 text-body text-smoke">{{ $restaurant->name }}</p>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Kategori') }}</div>
                <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $categoryCount }}</div>
            </div>
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Menu Item') }}</div>
                <div class="mt-1 text-heading-sm font-semibold text-ink">{{ $menuItemCount }}</div>
            </div>
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Status Publik') }}</div>
                <div class="mt-1">
                    @if ($restaurant->public_status === 'published')
                        <x-badge color="green">{{ __('Published') }}</x-badge>
                    @elseif ($restaurant->public_status === 'inactive')
                        <x-badge color="red">{{ __('Inactive') }}</x-badge>
                    @else
                        <x-badge color="gray">{{ __('Draft') }}</x-badge>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-4 rounded-card bg-pure-white p-6 shadow-ambient">
            <h2 class="font-semibold text-ink">{{ __('Langkah Cepat') }}</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('dashboard.profile.edit') }}" class="inline-flex items-center rounded-pill bg-signal-blue px-5 py-2.5 text-sm font-semibold text-pure-white transition hover:bg-bright-blue">{{ __('Lengkapi Profil') }}</a>
                <a href="{{ route('dashboard.categories.index') }}" class="inline-flex items-center rounded-pill border border-silver px-5 py-2.5 text-sm font-semibold text-ink transition hover:border-ink">{{ __('Kelola Kategori') }}</a>
                <a href="{{ route('dashboard.menu-items.index') }}" class="inline-flex items-center rounded-pill border border-silver px-5 py-2.5 text-sm font-semibold text-ink transition hover:border-ink">{{ __('Kelola Menu') }}</a>
                <a href="{{ route('dashboard.qr-code.show') }}" class="inline-flex items-center rounded-pill border border-silver px-5 py-2.5 text-sm font-semibold text-ink transition hover:border-ink">{{ __('Lihat QR Code') }}</a>
            </div>
        </div>

        @if ($restaurant->isPublished())
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <div class="text-sm text-smoke">{{ __('Menu Publik') }}</div>
                <a href="{{ route('public-menu.show', $restaurant->slug) }}" target="_blank" class="break-all text-signal-blue underline">
                    {{ route('public-menu.show', $restaurant->slug) }}
                </a>
            </div>
        @else
            <div class="rounded-card bg-honey-glow/15 p-4 text-sm text-amber-800">
                {{ __('Menu belum dipublikasikan. Ubah status ke "published" di halaman Profil Restoran agar pelanggan bisa melihat menu.') }}
            </div>
        @endif
    </div>
</x-app-layout>
