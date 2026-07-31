<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Feedback') }}</h1>
    </x-slot>

    <div class="max-w-3xl space-y-6">

        @if (session('status') === 'feedback-created')
            <div class="rounded-xl bg-vivid-green/15 p-4 text-sm text-green-700">
                {{ __('Terima kasih! Feedback Anda sudah kami terima.') }}
            </div>
        @endif

        <div class="rounded-card bg-pure-white p-6 shadow-ambient">
            <h2 class="mb-4 font-semibold text-ink">{{ __('Kirim Feedback') }}</h2>
            <form method="POST" action="{{ route('dashboard.feedback.store') }}" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="type" :value="__('Jenis')" />
                    <select id="type" name="type" class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
                        <option value="suggestion" @selected(old('type') === 'suggestion')>{{ __('Saran') }}</option>
                        <option value="bug" @selected(old('type') === 'bug')>{{ __('Laporan Bug') }}</option>
                        <option value="other" @selected(old('type') === 'other')>{{ __('Lainnya') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="message" :value="__('Pesan')" />
                    <textarea id="message" name="message" rows="4" required class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>
                <x-primary-button>{{ __('Kirim') }}</x-primary-button>
            </form>
        </div>

        <div class="divide-y divide-mist rounded-card bg-pure-white shadow-ambient">
            @forelse ($feedback as $item)
                <div class="space-y-1 p-4">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm font-medium text-ink">{{ ucfirst($item->type) }}</span>
                        <span class="text-xs text-smoke">{{ $item->created_at->translatedFormat('d M Y H:i') }} &middot; {{ ucfirst($item->status) }}</span>
                    </div>
                    <p class="text-sm text-smoke">{{ $item->message }}</p>
                    @if ($item->admin_note)
                        <p class="text-sm italic text-pewter">{{ __('Catatan admin') }}: {{ $item->admin_note }}</p>
                    @endif
                </div>
            @empty
                <div class="p-6 text-sm text-smoke">{{ __('Belum ada feedback yang dikirim.') }}</div>
            @endforelse
        </div>

        {{ $feedback->links() }}
    </div>
</x-app-layout>
