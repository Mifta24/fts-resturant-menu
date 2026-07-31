<x-app-layout>
    <x-slot name="header">
        <h1 class="text-heading-sm font-semibold text-ink">{{ __('Langganan') }}</h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">

        @if (session('status'))
            <div class="rounded-xl bg-vivid-green/15 p-4 text-sm text-green-700">
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
            <div class="rounded-xl bg-alert-red/15 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-card bg-pure-white p-6 shadow-ambient">
            <h2 class="mb-2 font-semibold text-ink">{{ __('Paket Saat Ini') }}</h2>
            @if ($activeSubscription)
                <div class="flex flex-wrap items-center gap-2 text-sm text-smoke">
                    <span>{{ $activeSubscription->package->name }}</span>
                    <span>&middot;</span>
                    <x-badge :color="$activeSubscription->status === 'active' ? 'green' : ($activeSubscription->status === 'pending' ? 'amber' : 'gray')">
                        {{ ucfirst($activeSubscription->status) }}
                    </x-badge>
                    @if ($activeSubscription->ends_at)
                        <span>&middot; {{ __('Berlaku sampai') }} {{ $activeSubscription->ends_at->translatedFormat('d F Y') }}</span>
                    @endif
                </div>
            @else
                <p class="text-sm text-smoke">{{ __('Belum ada paket aktif.') }}</p>
            @endif

            @if ($pendingSubscription)
                <div class="mt-3 text-sm text-amber-700">
                    {{ __('Menunggu pembayaran untuk paket') }} <strong>{{ $pendingSubscription->package->name }}</strong>
                    ({{ $pendingSubscription->billing_cycle }}).
                </div>
            @endif
        </div>

        @if ($isOwner)
            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                <h2 class="mb-4 font-semibold text-ink">{{ __('Pilih Paket') }}</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($packages as $package)
                        <div class="rounded-xl border border-mist p-4">
                            <div class="font-semibold text-ink">{{ $package->name }}</div>
                            <div class="mb-3 text-sm text-smoke">
                                Rp{{ number_format((float) $package->monthly_price, 0, ',', '.') }}/bulan
                                &middot; {{ $package->menu_limit ? $package->menu_limit.' menu' : __('Menu tanpa batas') }}
                            </div>
                            <form method="POST" action="{{ route('dashboard.subscription.select-package') }}" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $package->id }}">
                                <select name="billing_cycle" class="rounded-xl border-silver text-sm text-ink shadow-sm focus:border-signal-blue focus:ring-signal-blue">
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
                <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                    <h2 class="mb-4 font-semibold text-ink">{{ __('Unggah Bukti Pembayaran') }}</h2>
                    <form method="POST" action="{{ route('dashboard.subscription.upload-payment') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="proof" :value="__('Bukti Transfer (jpg, png, atau pdf)')" />
                            <input id="proof" type="file" name="proof" required class="mt-1 block w-full text-sm text-smoke" />
                            <x-input-error :messages="$errors->get('proof')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="reference_number" :value="__('Nomor Referensi (opsional)')" />
                            <x-text-input id="reference_number" class="mt-1 block w-full" type="text" name="reference_number" />
                            <x-input-error :messages="$errors->get('reference_number')" class="mt-2" />
                        </div>
                        <x-primary-button type="submit">{{ __('Kirim Bukti Pembayaran') }}</x-primary-button>
                    </form>
                </div>
            @endif
        @endif

        <div class="divide-y divide-mist rounded-card bg-pure-white shadow-ambient">
            <h2 class="p-6 pb-0 font-semibold text-ink">{{ __('Riwayat Pembayaran') }}</h2>
            @forelse ($payments as $payment)
                <div class="flex items-center justify-between gap-4 p-6">
                    <div>
                        <div class="text-sm font-medium text-ink">
                            {{ $payment->subscription->package->name ?? '-' }}
                            &middot; Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}
                        </div>
                        <div class="mt-1 flex items-center gap-2 text-xs text-smoke">
                            <span>{{ $payment->created_at->translatedFormat('d F Y H:i') }}</span>
                            <x-badge :color="$payment->status === 'approved' ? 'green' : ($payment->status === 'pending' ? 'amber' : 'red')">
                                {{ ucfirst($payment->status) }}
                            </x-badge>
                        </div>
                    </div>
                    @if ($payment->proof_path)
                        <a href="{{ route('dashboard.subscription.payments.proof', $payment) }}" class="text-sm text-signal-blue hover:underline">{{ __('Lihat Bukti') }}</a>
                    @endif
                </div>
            @empty
                <div class="p-6 text-sm text-smoke">{{ __('Belum ada riwayat pembayaran.') }}</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
