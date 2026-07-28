<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Paket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-sm rounded-md p-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Tambah Paket') }}</h3>
                <form method="POST" action="{{ route('admin.packages.store') }}" class="grid gap-3 sm:grid-cols-2">
                    @csrf
                    <input type="text" name="name" placeholder="{{ __('Nama') }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="text" name="code" placeholder="{{ __('Kode (mis. starter)') }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="number" step="0.01" name="monthly_price" placeholder="{{ __('Harga Bulanan') }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="number" step="0.01" name="yearly_price" placeholder="{{ __('Harga Tahunan (opsional)') }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="number" name="menu_limit" placeholder="{{ __('Batas Menu (kosong = unlimited)') }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="number" name="category_limit" placeholder="{{ __('Batas Kategori (kosong = unlimited)') }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="number" name="storage_limit_mb" value="50" placeholder="{{ __('Batas Storage (MB)') }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="number" name="team_limit" value="1" placeholder="{{ __('Batas Anggota Tim') }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <input type="number" name="language_limit" value="1" placeholder="{{ __('Batas Bahasa') }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                    <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 sm:col-span-2">
                        <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_statistics" value="1"> {{ __('Statistik') }}</label>
                        <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_custom_theme" value="1"> {{ __('Tema Kustom') }}</label>
                        <label class="inline-flex items-center gap-2"><input type="checkbox" name="remove_branding" value="1"> {{ __('Hapus Branding') }}</label>
                    </div>
                    <div class="sm:col-span-2">
                        <x-primary-button type="submit">{{ __('Tambah Paket') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg divide-y divide-gray-100 dark:divide-gray-700">
                @foreach ($packages as $package)
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.packages.update', $package) }}" class="grid gap-3 sm:grid-cols-2">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="name" value="{{ $package->name }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="text" name="code" value="{{ $package->code }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="number" step="0.01" name="monthly_price" value="{{ $package->monthly_price }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="number" step="0.01" name="yearly_price" value="{{ $package->yearly_price }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="number" name="menu_limit" value="{{ $package->menu_limit }}" placeholder="{{ __('unlimited') }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="number" name="category_limit" value="{{ $package->category_limit }}" placeholder="{{ __('unlimited') }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="number" name="storage_limit_mb" value="{{ $package->storage_limit_mb }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="number" name="team_limit" value="{{ $package->team_limit }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <input type="number" name="language_limit" value="{{ $package->language_limit }}" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm" />
                            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 sm:col-span-2">
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_statistics" value="1" @checked($package->has_statistics)> {{ __('Statistik') }}</label>
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_custom_theme" value="1" @checked($package->has_custom_theme)> {{ __('Tema Kustom') }}</label>
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="remove_branding" value="1" @checked($package->remove_branding)> {{ __('Hapus Branding') }}</label>
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked($package->is_active)> {{ __('Aktif') }}</label>
                            </div>
                            <div class="sm:col-span-2">
                                <x-secondary-button type="submit">{{ __('Simpan') }}</x-secondary-button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
