<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Profil Restoran') }}</h1>
    </x-slot>

    <div class="max-w-3xl">
        <div class="rounded-card bg-pure-white p-6 shadow-ambient">
            @if (session('status') === 'profile-updated')
                <div class="mb-4 rounded-xl bg-vivid-green/15 p-4 text-sm text-green-700">{{ __('Profil restoran berhasil diperbarui.') }}</div>
            @endif

            <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" :value="__('Nama Restoran')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $restaurant->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <p class="mt-1 text-xs text-smoke">{{ __('URL menu publik') }}: {{ url($restaurant->slug) }}</p>
                </div>

                <div>
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">{{ old('description', $restaurant->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="phone" :value="__('Telepon')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $restaurant->phone)" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="whatsapp" :value="__('WhatsApp')" />
                        <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full" :value="old('whatsapp', $restaurant->whatsapp)" />
                        <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="instagram_url" :value="__('Instagram URL')" />
                        <x-text-input id="instagram_url" name="instagram_url" type="text" class="mt-1 block w-full" :value="old('instagram_url', $restaurant->instagram_url)" />
                        <x-input-error :messages="$errors->get('instagram_url')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="primary_color" :value="__('Warna Utama')" />
                        <x-text-input id="primary_color" name="primary_color" type="text" placeholder="#ef4444" class="mt-1 block w-full" :value="old('primary_color', $restaurant->primary_color)" />
                        <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="maps_url" :value="__('Link Lokasi (Maps)')" />
                    <x-text-input id="maps_url" name="maps_url" type="text" class="mt-1 block w-full" :value="old('maps_url', $restaurant->maps_url)" />
                    <x-input-error :messages="$errors->get('maps_url')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="address" :value="__('Alamat')" />
                    <textarea id="address" name="address" rows="2" class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">{{ old('address', $restaurant->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="logo" :value="__('Logo')" />
                        @if ($restaurant->logo_path)
                            <img src="{{ Storage::url($restaurant->logo_path) }}" class="mb-2 mt-2 h-12 w-12 rounded-full object-cover">
                        @endif
                        <input id="logo" name="logo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-smoke">
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="cover" :value="__('Cover')" />
                        @if ($restaurant->cover_path)
                            <img src="{{ Storage::url($restaurant->cover_path) }}" class="mb-2 mt-2 h-12 w-24 rounded-lg object-cover">
                        @endif
                        <input id="cover" name="cover" type="file" accept="image/*" class="mt-1 block w-full text-sm text-smoke">
                        <x-input-error :messages="$errors->get('cover')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="public_status" :value="__('Status Publik')" />
                    <select id="public_status" name="public_status" class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
                        @foreach (['draft' => 'Draft', 'published' => 'Published', 'inactive' => 'Inactive'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('public_status', $restaurant->public_status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('public_status')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
