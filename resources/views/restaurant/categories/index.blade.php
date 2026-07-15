<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kategori Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Tambah Kategori') }}</h3>
                <form method="POST" action="{{ route('dashboard.categories.store') }}" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="{{ __('Nama kategori') }}" required class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" />
                    <x-primary-button>{{ __('Tambah') }}</x-primary-button>
                </form>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($categories as $category)
                    <div class="p-4 flex items-center justify-between gap-4">
                        <form method="POST" action="{{ route('dashboard.categories.update', $category) }}" class="flex-1 flex flex-col sm:flex-row sm:items-center gap-3">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="name" value="{{ $category->name }}" class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" @checked($category->is_active) class="rounded border-gray-300 dark:border-gray-700">
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
                    <div class="p-6 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada kategori. Tambahkan kategori pertama di atas.') }}</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
