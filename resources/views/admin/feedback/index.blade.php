<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feedback') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="p-4">{{ __('Restoran') }}</th>
                            <th class="p-4">{{ __('Jenis') }}</th>
                            <th class="p-4">{{ __('Pesan') }}</th>
                            <th class="p-4">{{ __('Dikirim') }}</th>
                            <th class="p-4">{{ __('Status') }}</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($feedback as $item)
                            <tr>
                                <td class="p-4 text-gray-800 dark:text-gray-200">{{ $item->restaurant->name }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ ucfirst($item->type) }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400 max-w-sm truncate" title="{{ $item->message }}">{{ $item->message }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $item->created_at->translatedFormat('d M Y H:i') }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ ucfirst($item->status) }}</td>
                                <td class="p-4 text-right">
                                    <form method="POST" action="{{ route('admin.feedback.update', $item) }}" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                            @foreach (['new', 'reviewed', 'resolved'] as $status)
                                                <option value="{{ $status }}" @selected($item->status === $status)>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="admin_note" value="{{ $item->admin_note }}" placeholder="{{ __('Catatan') }}" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" />
                                        <x-secondary-button type="submit">{{ __('Simpan') }}</x-secondary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $feedback->links() }}
        </div>
    </div>
</x-app-layout>
