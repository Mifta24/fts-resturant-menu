<x-guest-layout>
    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-1">
        {{ __('Buat Restoran Anda') }}
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        {{ __('Satu langkah lagi sebelum masuk ke dashboard. Data ini bisa diubah kapan saja nanti.') }}
    </p>

    <form method="POST" action="{{ route('dashboard.onboarding.store') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Restoran')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Deskripsi Singkat (opsional)')" />
            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor Telepon (opsional)')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Mulai Kelola Menu') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
