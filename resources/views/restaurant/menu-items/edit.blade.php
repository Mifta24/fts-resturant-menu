<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Menu') }} &mdash; {{ $menuItem->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('dashboard.menu-items.update', $menuItem) }}" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori')" />
                        <select id="category_id" name="category_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id === $menuItem->category_id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="name" :value="__('Nama Menu')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $menuItem->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="price" :value="__('Harga (Rp)')" />
                        <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('price', $menuItem->price)" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="image" :value="__('Foto Baru (opsional)')" />
                        @if ($menuItem->image_source)
                            <img src="{{ $menuItem->image_source }}" alt="{{ $menuItem->name }}" class="h-12 w-12 rounded object-cover mt-1 mb-1">
                        @endif
                        <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-400">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="image_url" :value="__('Atau URL Foto')" />
                        <x-text-input id="image_url" name="image_url" type="url" class="mt-1 block w-full" :value="old('image_url', $menuItem->image_url)" placeholder="https://contoh.com/foto-menu.jpg" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Kosongkan URL untuk menghapus foto dari URL. Jika memilih file baru, file tersebut akan digunakan.') }}</p>
                        <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description', $menuItem->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" name="is_available" value="1" @checked($menuItem->is_available) class="rounded border-gray-300 dark:border-gray-700">
                            {{ __('Tersedia') }}
                        </label>
                    </div>
                    <div class="sm:col-span-2 flex justify-between">
                        <a href="{{ route('dashboard.menu-items.index') }}" class="text-sm text-gray-600 dark:text-gray-400 underline self-center">{{ __('Kembali') }}</a>
                        <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
