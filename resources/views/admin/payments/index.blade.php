<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="p-4">{{ __('Restoran') }}</th>
                            <th class="p-4">{{ __('Paket') }}</th>
                            <th class="p-4">{{ __('Jumlah') }}</th>
                            <th class="p-4">{{ __('Status') }}</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($payments as $payment)
                            <tr>
                                <td class="p-4 text-gray-800 dark:text-gray-200">{{ $payment->restaurant->name }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $payment->subscription->package->name ?? '-' }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $payment->status }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:underline">{{ __('Detail') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
