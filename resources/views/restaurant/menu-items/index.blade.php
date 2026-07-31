<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Menu Item') }}</h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">

        @if (session('status') === 'menu-items-bulk-imported')
            <div class="rounded-xl bg-vivid-green/15 p-4 text-sm text-green-700">
                {{ __(':created menu berhasil ditambahkan.', ['created' => session('bulkImportCreated')]) }}
                @if (session('bulkImportSkipped'))
                    {{ __(':skipped baris dilewati (format salah atau batas paket tercapai).', ['skipped' => session('bulkImportSkipped')]) }}
                @endif
            </div>
        @endif

        <details class="rounded-card bg-pure-white p-6 shadow-ambient">
            <summary class="cursor-pointer font-semibold text-ink">{{ __('Import Cepat (Assisted Setup)') }}</summary>
            <p class="mt-2 text-sm text-smoke">
                {{ __('Cocok untuk sesi bantuan setup awal. Tempel satu menu per baris dengan format:') }}
                <code class="mt-1 block rounded-lg bg-snow-gray p-2 text-xs">Kategori | Nama Menu | Harga</code>
            </p>
            <form method="POST" action="{{ route('dashboard.menu-items.bulk-import') }}" class="mt-4 space-y-3">
                @csrf
                <textarea name="data" rows="6" placeholder="Makanan | Nasi Goreng | 25000&#10;Makanan | Mie Goreng | 22000&#10;Minuman | Es Teh Manis | 5000" class="block w-full rounded-xl border-silver font-mono text-xs text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">{{ old('data') }}</textarea>
                <x-input-error :messages="$errors->get('data')" class="mt-2" />
                <x-primary-button>{{ __('Import Menu') }}</x-primary-button>
            </form>
        </details>

        @if ($categories->isEmpty())
            <div class="rounded-xl bg-honey-glow/15 p-4 text-sm text-amber-800">
                {{ __('Buat kategori terlebih dahulu sebelum menambahkan menu.') }}
                <a href="{{ route('dashboard.categories.index') }}" class="font-medium underline">{{ __('Kelola Kategori') }}</a>
            </div>
        @else
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <h2 class="mb-4 font-semibold text-ink">{{ __('Tambah Menu') }}</h2>
                <form method="POST" action="{{ route('dashboard.menu-items.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @csrf
                    <div>
                        <x-input-label for="category_id" :value="__('Kategori')" />
                        <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
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
                        <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-smoke">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="image_url" :value="__('Atau URL Foto')" />
                        <x-text-input id="image_url" name="image_url" type="url" class="mt-1 block w-full" :value="old('image_url')" placeholder="https://contoh.com/foto-menu.jpg" />
                        <p class="mt-1 text-xs text-smoke">{{ __('Jika file dan URL diisi, file yang diunggah akan digunakan.') }}</p>
                        <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description" rows="2" class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="flex justify-end sm:col-span-2">
                        <x-primary-button>{{ __('Tambah Menu') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="divide-y divide-mist rounded-card bg-pure-white shadow-ambient">
                @forelse ($menuItems as $item)
                    <div class="flex flex-col gap-4 p-4 sm:flex-row sm:items-center">
                        @if ($item->image_source)
                            <img src="{{ $item->image_source }}" alt="{{ $item->name }}" class="h-16 w-16 shrink-0 rounded-xl object-cover">
                        @else
                            <div class="h-16 w-16 shrink-0 rounded-xl bg-snow-gray"></div>
                        @endif

                        <div class="flex-1">
                            <div class="font-medium text-ink">{{ $item->name }}</div>
                            <div class="text-sm text-smoke">{{ $item->category->name }} &middot; Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>

                        <form method="POST" action="{{ route('dashboard.menu-items.availability', $item) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-pill px-3 py-1 text-xs font-medium transition {{ $item->is_available ? 'bg-vivid-green/15 text-green-700 hover:bg-vivid-green/25' : 'bg-mist text-smoke hover:bg-silver/60' }}">
                                {{ $item->is_available ? __('Tersedia') : __('Habis') }}
                            </button>
                        </form>

                        <a href="{{ route('dashboard.menu-items.edit', $item) }}" class="text-sm font-medium text-signal-blue underline hover:text-bright-blue">{{ __('Edit') }}</a>

                        <form method="POST" action="{{ route('dashboard.menu-items.destroy', $item) }}" onsubmit="return confirm('{{ __('Hapus menu ini?') }}')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">{{ __('Hapus') }}</x-danger-button>
                        </form>
                    </div>
                @empty
                    <div class="p-6 text-sm text-smoke">{{ __('Belum ada menu.') }}</div>
                @endforelse
            </div>
        @endif
    </div>
</x-app-layout>
