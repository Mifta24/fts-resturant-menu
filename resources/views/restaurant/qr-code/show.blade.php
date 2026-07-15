<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center space-y-4">
                <img src="{{ route('dashboard.qr-code.download') }}" alt="QR Code" class="mx-auto w-64 h-64 border border-gray-200 dark:border-gray-700 rounded">

                <p class="text-sm text-gray-500 dark:text-gray-400 break-all">{{ $publicUrl }}</p>

                <a href="{{ route('dashboard.qr-code.download') }}" download class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 rounded-md text-white dark:text-gray-800 text-sm font-medium">
                    {{ __('Download QR Code') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
