<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menu Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($categories->isEmpty())
                <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 text-sm text-yellow-800 dark:text-yellow-200">
                    {{ __('Buat kategori terlebih dahulu sebelum menambahkan menu.') }}
                    <a href="{{ route('dashboard.categories.index') }}" class="underline font-medium">{{ __('Kelola Kategori') }}</a>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Tambah Menu') }}</h3>
                    <form method="POST" action="{{ route('dashboard.menu-items.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @csrf
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Nama Menu')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="price" :value="__('Harga (Rp)')" />
                            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="image" :value="__('Foto')" />
                            <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-400">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="image_url" :value="__('Atau URL Foto')" />
                            <x-text-input id="image_url" name="image_url" type="url" class="mt-1 block w-full" :value="old('image_url')" placeholder="https://contoh.com/foto-menu.jpg" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Jika file dan URL diisi, file yang diunggah akan digunakan.') }}</p>
                            <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2 flex justify-end">
                            <x-primary-button>{{ __('Tambah Menu') }}</x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($menuItems as $item)
                        <div class="p-4 flex flex-col sm:flex-row sm:items-center gap-4">
                            @if ($item->image_source)
                                <img src="{{ $item->image_source }}" alt="{{ $item->name }}" class="h-16 w-16 rounded object-cover shrink-0">
                            @else
                                <div class="h-16 w-16 rounded bg-gray-100 dark:bg-gray-700 shrink-0"></div>
                            @endif

                            <div class="flex-1">
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $item->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->category->name }} &middot; Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>

                            <form method="POST" action="{{ route('dashboard.menu-items.availability', $item) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-medium px-3 py-1 rounded-full {{ $item->is_available ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $item->is_available ? __('Tersedia') : __('Habis') }}
                                </button>
                            </form>

                            <a href="{{ route('dashboard.menu-items.edit', $item) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 underline">{{ __('Edit') }}</a>

                            <form method="POST" action="{{ route('dashboard.menu-items.destroy', $item) }}" onsubmit="return confirm('{{ __('Hapus menu ini?') }}')">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">{{ __('Hapus') }}</x-danger-button>
                            </form>
                        </div>
                    @empty
                        <div class="p-6 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada menu.') }}</div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
