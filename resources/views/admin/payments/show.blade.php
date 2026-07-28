<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm rounded-md p-4">
                    {{ __('Pembayaran berhasil diproses.') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <p><span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Restoran') }}:</span> {{ $payment->restaurant->name }}</p>
                <p><span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Paket') }}:</span> {{ $payment->subscription->package->name ?? '-' }} ({{ $payment->subscription->billing_cycle }})</p>
                <p><span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Jumlah') }}:</span> Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}</p>
                <p><span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Referensi') }}:</span> {{ $payment->reference_number ?? '-' }}</p>
                <p><span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Status') }}:</span> {{ $payment->status }}</p>
                @if ($payment->verifier)
                    <p><span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Diverifikasi oleh') }}:</span> {{ $payment->verifier->name }}</p>
                @endif
                @if ($payment->notes)
                    <p><span class="font-medium text-gray-800 dark:text-gray-200">{{ __('Catatan') }}:</span> {{ $payment->notes }}</p>
                @endif
                @if ($payment->proof_path)
                    <p><a href="{{ route('admin.payments.proof', $payment) }}" class="text-blue-600 hover:underline">{{ __('Lihat Bukti Pembayaran') }}</a></p>
                @endif
            </div>

            @if ($payment->status === \App\Models\Payment::STATUS_PENDING)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col sm:flex-row gap-3">
                    <form method="POST" action="{{ route('admin.payments.approve', $payment) }}">
                        @csrf
                        <x-primary-button type="submit">{{ __('Setujui') }}</x-primary-button>
                    </form>
                    <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="flex items-center gap-2">
                        @csrf
                        <input type="text" name="notes" placeholder="{{ __('Alasan penolakan (opsional)') }}" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" />
                        <x-danger-button type="submit">{{ __('Tolak') }}</x-danger-button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
