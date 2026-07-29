<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feedback') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status') === 'feedback-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm rounded-md">
                    {{ __('Terima kasih! Feedback Anda sudah kami terima.') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Kirim Feedback') }}</h3>
                <form method="POST" action="{{ route('dashboard.feedback.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="type" :value="__('Jenis')" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="suggestion" @selected(old('type') === 'suggestion')>{{ __('Saran') }}</option>
                            <option value="bug" @selected(old('type') === 'bug')>{{ __('Laporan Bug') }}</option>
                            <option value="other" @selected(old('type') === 'other')>{{ __('Lainnya') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="message" :value="__('Pesan')" />
                        <textarea id="message" name="message" rows="4" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <x-primary-button>{{ __('Kirim') }}</x-primary-button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($feedback as $item)
                    <div class="p-4 space-y-1">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ ucfirst($item->type) }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $item->created_at->translatedFormat('d M Y H:i') }} &middot; {{ ucfirst($item->status) }}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->message }}</p>
                        @if ($item->admin_note)
                            <p class="text-sm text-gray-500 dark:text-gray-500 italic">{{ __('Catatan admin') }}: {{ $item->admin_note }}</p>
                        @endif
                    </div>
                @empty
                    <div class="p-6 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada feedback yang dikirim.') }}</div>
                @endforelse
            </div>

            {{ $feedback->links() }}
        </div>
    </div>
</x-app-layout>
