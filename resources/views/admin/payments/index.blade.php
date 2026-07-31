<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Pembayaran') }}</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="overflow-x-auto rounded-card bg-pure-white shadow-ambient">
            <table class="min-w-full text-sm">
                <thead class="border-b border-mist text-left text-smoke">
                    <tr>
                        <th class="p-4 font-medium">{{ __('Restoran') }}</th>
                        <th class="p-4 font-medium">{{ __('Paket') }}</th>
                        <th class="p-4 font-medium">{{ __('Jumlah') }}</th>
                        <th class="p-4 font-medium">{{ __('Status') }}</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mist">
                    @foreach ($payments as $payment)
                        <tr>
                            <td class="p-4 text-ink">{{ $payment->restaurant->name }}</td>
                            <td class="p-4 text-smoke">{{ $payment->subscription->package->name ?? '-' }}</td>
                            <td class="p-4 text-smoke">Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <x-badge :color="$payment->status === 'approved' ? 'green' : ($payment->status === 'pending' ? 'amber' : 'red')">
                                    {{ $payment->status }}
                                </x-badge>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="text-signal-blue hover:underline">{{ __('Detail') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $payments->links() }}
    </div>
</x-app-layout>
