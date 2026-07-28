<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Langganan') }}
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
                            <th class="p-4">{{ __('Siklus') }}</th>
                            <th class="p-4">{{ __('Berakhir') }}</th>
                            <th class="p-4">{{ __('Status') }}</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td class="p-4 text-gray-800 dark:text-gray-200">{{ $subscription->restaurant->name }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $subscription->package->name ?? '-' }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $subscription->billing_cycle }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $subscription->ends_at?->translatedFormat('d M Y') ?? '-' }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $subscription->status }}</td>
                                <td class="p-4 text-right">
                                    <form method="POST" action="{{ route('admin.subscriptions.update', $subscription) }}" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                            @foreach (['pending', 'active', 'expired', 'cancelled'] as $status)
                                                <option value="{{ $status }}" @selected($subscription->status === $status)>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <x-secondary-button type="submit">{{ __('Simpan') }}</x-secondary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $subscriptions->links() }}
        </div>
    </div>
</x-app-layout>
