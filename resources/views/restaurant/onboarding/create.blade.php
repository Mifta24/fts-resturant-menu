<x-guest-layout>
    <h2 class="mb-1 text-subheading font-semibold text-ink">
        {{ __('Buat Restoran Anda') }}
    </h2>
    <p class="mb-4 text-sm text-smoke">
        {{ __('Satu langkah lagi sebelum masuk ke dashboard. Data ini bisa diubah kapan saja nanti.') }}
    </p>

    <form method="POST" action="{{ route('dashboard.onboarding.store') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Restoran')" />
            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Deskripsi Singkat (opsional)')" />
            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-xl border-silver text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor Telepon (opsional)')" />
            <x-text-input id="phone" class="mt-1 block w-full" type="text" name="phone" :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="mt-6 flex items-center justify-end">
            <x-primary-button>
                {{ __('Mulai Kelola Menu') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
