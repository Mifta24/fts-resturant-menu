<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Feedback') }}</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="overflow-x-auto rounded-card bg-pure-white shadow-ambient">
            <table class="min-w-full text-sm">
                <thead class="border-b border-mist text-left text-smoke">
                    <tr>
                        <th class="p-4 font-medium">{{ __('Restoran') }}</th>
                        <th class="p-4 font-medium">{{ __('Jenis') }}</th>
                        <th class="p-4 font-medium">{{ __('Pesan') }}</th>
                        <th class="p-4 font-medium">{{ __('Dikirim') }}</th>
                        <th class="p-4 font-medium">{{ __('Status') }}</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mist">
                    @foreach ($feedback as $item)
                        <tr>
                            <td class="p-4 text-ink">{{ $item->restaurant->name }}</td>
                            <td class="p-4 text-smoke">{{ ucfirst($item->type) }}</td>
                            <td class="max-w-sm truncate p-4 text-smoke" title="{{ $item->message }}">{{ $item->message }}</td>
                            <td class="p-4 text-smoke">{{ $item->created_at->translatedFormat('d M Y H:i') }}</td>
                            <td class="p-4">
                                <x-badge :color="$item->status === 'resolved' ? 'green' : ($item->status === 'reviewed' ? 'amber' : 'blue')">
                                    {{ ucfirst($item->status) }}
                                </x-badge>
                            </td>
                            <td class="p-4 text-right">
                                <form method="POST" action="{{ route('admin.feedback.update', $item) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
                                        @foreach (['new', 'reviewed', 'resolved'] as $status)
                                            <option value="{{ $status }}" @selected($item->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="admin_note" value="{{ $item->admin_note }}" placeholder="{{ __('Catatan') }}" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
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
</x-app-layout>
