<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Kategori Menu') }}</h1>
    </x-slot>

    <div class="max-w-3xl space-y-6">

        <div class="rounded-card bg-pure-white p-6 shadow-ambient">
            <h2 class="mb-4 font-semibold text-ink">{{ __('Tambah Kategori') }}</h2>
            <form method="POST" action="{{ route('dashboard.categories.store') }}" class="flex flex-col gap-3 sm:flex-row">
                @csrf
                <input type="text" name="name" placeholder="{{ __('Nama kategori') }}" required class="flex-1 rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <x-primary-button>{{ __('Tambah') }}</x-primary-button>
            </form>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="divide-y divide-mist rounded-card bg-pure-white shadow-ambient">
            @forelse ($categories as $category)
                <div class="flex items-center justify-between gap-4 p-4">
                    <form method="POST" action="{{ route('dashboard.categories.update', $category) }}" class="flex flex-1 flex-col gap-3 sm:flex-row sm:items-center">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="name" value="{{ $category->name }}" class="flex-1 rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <label class="inline-flex items-center gap-2 text-sm text-smoke">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" @checked($category->is_active) class="rounded border-silver text-signal-blue focus:ring-signal-blue">
                            {{ __('Aktif') }}
                        </label>
                        <x-secondary-button type="submit">{{ __('Simpan') }}</x-secondary-button>
                    </form>
                    <form method="POST" action="{{ route('dashboard.categories.destroy', $category) }}" onsubmit="return confirm('{{ __('Hapus kategori ini?') }}')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">{{ __('Hapus') }}</x-danger-button>
                    </form>
                </div>
            @empty
                <div class="p-6 text-sm text-smoke">{{ __('Belum ada kategori. Tambahkan kategori pertama di atas.') }}</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
