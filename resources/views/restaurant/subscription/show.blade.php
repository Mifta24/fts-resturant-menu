<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Langganan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm rounded-md p-4">
                    @switch(session('status'))
                        @case('subscription-activated')
                            {{ __('Paket berhasil diaktifkan.') }}
                            @break
                        @case('subscription-pending')
                            {{ __('Paket dipilih. Silakan unggah bukti pembayaran untuk diverifikasi admin.') }}
                            @break
                        @case('payment-uploaded')
                            {{ __('Bukti pembayaran berhasil diunggah dan menunggu verifikasi admin.') }}
                            @break
                        @default
                            {{ session('status') }}
                    @endswitch
                </div>
            @endif

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
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Paket Saat Ini') }}</h3>
                @if ($activeSubscription)
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $activeSubscription->package->name }}
                        &middot; {{ __('Status') }}: <span class="font-medium">{{ $activeSubscription->status }}</span>
                        @if ($activeSubscription->ends_at)
                            &middot; {{ __('Berlaku sampai') }} {{ $activeSubscription->ends_at->translatedFormat('d F Y') }}
                        @endif
                    </p>
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Belum ada paket aktif.') }}</p>
                @endif

                @if ($pendingSubscription)
                    <div class="mt-3 text-sm text-amber-700 dark:text-amber-400">
                        {{ __('Menunggu pembayaran untuk paket') }} <strong>{{ $pendingSubscription->package->name }}</strong>
                        ({{ $pendingSubscription->billing_cycle }}).
                    </div>
                @endif
            </div>

            @if ($isOwner)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Pilih Paket') }}</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($packages as $package)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="font-semibold text-gray-800 dark:text-gray-200">{{ $package->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    Rp{{ number_format((float) $package->monthly_price, 0, ',', '.') }}/bulan
                                    &middot; {{ $package->menu_limit ? $package->menu_limit.' menu' : __('Menu tanpa batas') }}
                                </div>
                                <form method="POST" action="{{ route('dashboard.subscription.select-package') }}" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <select name="billing_cycle" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                        <option value="monthly">{{ __('Bulanan') }}</option>
                                        <option value="yearly">{{ __('Tahunan') }}</option>
                                    </select>
                                    <x-secondary-button type="submit">{{ __('Pilih') }}</x-secondary-button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($pendingSubscription)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Unggah Bukti Pembayaran') }}</h3>
                        <form method="POST" action="{{ route('dashboard.subscription.upload-payment') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="proof" :value="__('Bukti Transfer (jpg, png, atau pdf)')" />
                                <input id="proof" type="file" name="proof" required class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-400" />
                                <x-input-error :messages="$errors->get('proof')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="reference_number" :value="__('Nomor Referensi (opsional)')" />
                                <x-text-input id="reference_number" class="block mt-1 w-full" type="text" name="reference_number" />
                                <x-input-error :messages="$errors->get('reference_number')" class="mt-2" />
                            </div>
                            <x-primary-button type="submit">{{ __('Kirim Bukti Pembayaran') }}</x-primary-button>
                        </form>
                    </div>
                @endif
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg divide-y divide-gray-100 dark:divide-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 p-6 pb-0">{{ __('Riwayat Pembayaran') }}</h3>
                @forelse ($payments as $payment)
                    <div class="p-6 flex items-center justify-between gap-4">
                        <div>
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $payment->subscription->package->name ?? '-' }}
                                &middot; Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $payment->created_at->translatedFormat('d F Y H:i') }}
                                &middot; {{ __('Status') }}: {{ $payment->status }}
                            </div>
                        </div>
                        @if ($payment->proof_path)
                            <a href="{{ route('dashboard.subscription.payments.proof', $payment) }}" class="text-sm text-blue-600 hover:underline">{{ __('Lihat Bukti') }}</a>
                        @endif
                    </div>
                @empty
                    <div class="p-6 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada riwayat pembayaran.') }}</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
