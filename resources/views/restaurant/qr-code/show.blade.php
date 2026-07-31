<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('QR Code Menu') }}</h1>
    </x-slot>

    <div class="max-w-md">
        <div class="space-y-4 rounded-card bg-pure-white p-6 text-center shadow-ambient">
            <img src="{{ route('dashboard.qr-code.download') }}" alt="QR Code" class="mx-auto h-64 w-64 rounded-xl border border-mist">

            <p class="break-all text-sm text-smoke">{{ $publicUrl }}</p>

            <a href="{{ route('dashboard.qr-code.download') }}" download class="inline-flex items-center rounded-pill bg-signal-blue px-5 py-2.5 text-sm font-semibold text-pure-white transition hover:bg-bright-blue">
                {{ __('Download QR Code') }}
            </a>
        </div>
    </div>
</x-app-layout>
