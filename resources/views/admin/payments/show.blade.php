<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Detail Pembayaran') }}</h1>
    </x-slot>

    <div class="max-w-2xl space-y-6">

        @if (session('status'))
            <div class="rounded-xl bg-vivid-green/15 p-4 text-sm text-green-700">
                {{ __('Pembayaran berhasil diproses.') }}
            </div>
        @endif

        <div class="space-y-2 rounded-card bg-pure-white p-6 text-sm text-smoke shadow-ambient">
            <p><span class="font-medium text-ink">{{ __('Restoran') }}:</span> {{ $payment->restaurant->name }}</p>
            <p><span class="font-medium text-ink">{{ __('Paket') }}:</span> {{ $payment->subscription->package->name ?? '-' }} ({{ $payment->subscription->billing_cycle }})</p>
            <p><span class="font-medium text-ink">{{ __('Jumlah') }}:</span> Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}</p>
            <p><span class="font-medium text-ink">{{ __('Referensi') }}:</span> {{ $payment->reference_number ?? '-' }}</p>
            <p class="flex items-center gap-2">
                <span class="font-medium text-ink">{{ __('Status') }}:</span>
                <x-badge :color="$payment->status === 'approved' ? 'green' : ($payment->status === 'pending' ? 'amber' : 'red')">
                    {{ $payment->status }}
                </x-badge>
            </p>
            @if ($payment->verifier)
                <p><span class="font-medium text-ink">{{ __('Diverifikasi oleh') }}:</span> {{ $payment->verifier->name }}</p>
            @endif
            @if ($payment->notes)
                <p><span class="font-medium text-ink">{{ __('Catatan') }}:</span> {{ $payment->notes }}</p>
            @endif
            @if ($payment->proof_path)
                <p><a href="{{ route('admin.payments.proof', $payment) }}" class="text-signal-blue hover:underline">{{ __('Lihat Bukti Pembayaran') }}</a></p>
            @endif
        </div>

        @if ($payment->status === \App\Models\Payment::STATUS_PENDING)
            <div class="flex flex-col gap-3 rounded-card bg-pure-white p-6 shadow-ambient sm:flex-row">
                <form method="POST" action="{{ route('admin.payments.approve', $payment) }}">
                    @csrf
                    <x-primary-button type="submit">{{ __('Setujui') }}</x-primary-button>
                </form>
                <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="flex items-center gap-2">
                    @csrf
                    <input type="text" name="notes" placeholder="{{ __('Alasan penolakan (opsional)') }}" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                    <x-danger-button type="submit">{{ __('Tolak') }}</x-danger-button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
