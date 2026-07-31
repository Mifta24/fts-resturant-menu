<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Edit Menu') }}</h1>
        <p class="mt-1 text-body text-smoke">{{ $menuItem->name }}</p>
    </x-slot>

    <div class="max-w-2xl">
        <div class="rounded-card bg-pure-white p-6 shadow-ambient">
            <form method="POST" action="{{ route('dashboard.menu-items.update', $menuItem) }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="category_id" :value="__('Kategori')" />
                    <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
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
                        <img src="{{ $menuItem->image_source }}" alt="{{ $menuItem->name }}" class="mb-1 mt-1 h-12 w-12 rounded-lg object-cover">
                    @endif
                    <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-smoke">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div class="sm:col-span-2">
                    <x-input-label for="image_url" :value="__('Atau URL Foto')" />
                    <x-text-input id="image_url" name="image_url" type="url" class="mt-1 block w-full" :value="old('image_url', $menuItem->image_url)" placeholder="https://contoh.com/foto-menu.jpg" />
                    <p class="mt-1 text-xs text-smoke">{{ __('Kosongkan URL untuk menghapus foto dari URL. Jika memilih file baru, file tersebut akan digunakan.') }}</p>
                    <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                </div>
                <div class="sm:col-span-2">
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <textarea id="description" name="description" rows="2" class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">{{ old('description', $menuItem->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="sm:col-span-2">
                    <label class="inline-flex items-center gap-2 text-sm text-smoke">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1" @checked($menuItem->is_available) class="rounded border-silver text-signal-blue focus:ring-signal-blue">
                        {{ __('Tersedia') }}
                    </label>
                </div>
                <div class="flex justify-between sm:col-span-2">
                    <a href="{{ route('dashboard.menu-items.index') }}" class="self-center text-sm text-smoke underline">{{ __('Kembali') }}</a>
                    <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
