<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }} &mdash; {{ $restaurant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Kategori') }}</div>
                    <div class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $categoryCount }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Menu Item') }}</div>
                    <div class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $menuItemCount }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Status Publik') }}</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 capitalize">{{ $restaurant->public_status }}</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200">{{ __('Langkah Cepat') }}</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 rounded-md text-white dark:text-gray-800 text-sm font-medium">{{ __('Lengkapi Profil') }}</a>
                    <a href="{{ route('dashboard.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 text-sm font-medium">{{ __('Kelola Kategori') }}</a>
                    <a href="{{ route('dashboard.menu-items.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 text-sm font-medium">{{ __('Kelola Menu') }}</a>
                    <a href="{{ route('dashboard.qr-code.show') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 text-sm font-medium">{{ __('Lihat QR Code') }}</a>
                </div>
            </div>

            @if ($restaurant->isPublished())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Menu Publik') }}</div>
                    <a href="{{ route('public-menu.show', $restaurant->slug) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 underline break-all">
                        {{ route('public-menu.show', $restaurant->slug) }}
                    </a>
                </div>
            @else
                <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 text-sm text-yellow-800 dark:text-yellow-200">
                    {{ __('Menu belum dipublikasikan. Ubah status ke "published" di halaman Profil Restoran agar pelanggan bisa melihat menu.') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
