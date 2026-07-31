<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Paket') }}</h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">

        @if ($errors->any())
            <div class="rounded-xl bg-alert-red/15 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-card bg-pure-white p-6 shadow-ambient">
            <h2 class="mb-4 font-semibold text-ink">{{ __('Tambah Paket') }}</h2>
            <form method="POST" action="{{ route('admin.packages.store') }}" class="grid gap-3 sm:grid-cols-2">
                @csrf
                <input type="text" name="name" placeholder="{{ __('Nama') }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <input type="text" name="code" placeholder="{{ __('Kode (mis. starter)') }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <x-rupiah-input name="monthly_price" :value="0" placeholder="{{ __('Harga Bulanan') }}" required />
                <x-rupiah-input name="yearly_price" :value="null" nullable placeholder="{{ __('Harga Tahunan (opsional)') }}" />
                <input type="number" name="menu_limit" placeholder="{{ __('Batas Menu (kosong = unlimited)') }}" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <input type="number" name="category_limit" placeholder="{{ __('Batas Kategori (kosong = unlimited)') }}" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <input type="number" name="storage_limit_mb" value="50" placeholder="{{ __('Batas Storage (MB)') }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <input type="number" name="team_limit" value="1" placeholder="{{ __('Batas Anggota Tim') }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <input type="number" name="language_limit" value="1" placeholder="{{ __('Batas Bahasa') }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                <div class="flex flex-wrap items-center gap-4 text-sm text-smoke sm:col-span-2">
                    <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_statistics" value="1" class="rounded border-silver text-signal-blue focus:ring-signal-blue"> {{ __('Statistik') }}</label>
                    <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_custom_theme" value="1" class="rounded border-silver text-signal-blue focus:ring-signal-blue"> {{ __('Tema Kustom') }}</label>
                    <label class="inline-flex items-center gap-2"><input type="checkbox" name="remove_branding" value="1" class="rounded border-silver text-signal-blue focus:ring-signal-blue"> {{ __('Hapus Branding') }}</label>
                </div>
                <div class="sm:col-span-2">
                    <x-primary-button type="submit">{{ __('Tambah Paket') }}</x-primary-button>
                </div>
            </form>
        </div>

        <div class="divide-y divide-mist rounded-card bg-pure-white shadow-ambient">
            @foreach ($packages as $package)
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.packages.update', $package) }}" class="grid gap-3 sm:grid-cols-2">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="name" value="{{ $package->name }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <input type="text" name="code" value="{{ $package->code }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <x-rupiah-input name="monthly_price" :value="$package->monthly_price" required />
                        <x-rupiah-input name="yearly_price" :value="$package->yearly_price" nullable />
                        <input type="number" name="menu_limit" value="{{ $package->menu_limit }}" placeholder="{{ __('unlimited') }}" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <input type="number" name="category_limit" value="{{ $package->category_limit }}" placeholder="{{ __('unlimited') }}" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <input type="number" name="storage_limit_mb" value="{{ $package->storage_limit_mb }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <input type="number" name="team_limit" value="{{ $package->team_limit }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <input type="number" name="language_limit" value="{{ $package->language_limit }}" required class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue" />
                        <div class="flex flex-wrap items-center gap-4 text-sm text-smoke sm:col-span-2">
                            <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_statistics" value="1" @checked($package->has_statistics) class="rounded border-silver text-signal-blue focus:ring-signal-blue"> {{ __('Statistik') }}</label>
                            <label class="inline-flex items-center gap-2"><input type="checkbox" name="has_custom_theme" value="1" @checked($package->has_custom_theme) class="rounded border-silver text-signal-blue focus:ring-signal-blue"> {{ __('Tema Kustom') }}</label>
                            <label class="inline-flex items-center gap-2"><input type="checkbox" name="remove_branding" value="1" @checked($package->remove_branding) class="rounded border-silver text-signal-blue focus:ring-signal-blue"> {{ __('Hapus Branding') }}</label>
                            <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked($package->is_active) class="rounded border-silver text-signal-blue focus:ring-signal-blue"> {{ __('Aktif') }}</label>
                        </div>
                        <div class="sm:col-span-2">
                            <x-secondary-button type="submit">{{ __('Simpan') }}</x-secondary-button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
