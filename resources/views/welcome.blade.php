<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'FTS Menu') }} — Satu QR, Menu Selalu Terbaru</title>
        <meta name="description" content="Platform menu digital untuk restoran dan kafe. Kelola menu, harga, foto, dan status ketersediaan dari HP — pelanggan tinggal scan QR code.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-pure-white font-sans text-ink antialiased">

        <div x-data="{ mobileNavOpen: false }">
            {{-- Navigation --}}
            <header class="sticky top-0 z-20 border-b border-mist bg-pure-white/90 backdrop-blur">
                <div class="mx-auto flex max-w-page items-center justify-between px-6 py-4 lg:px-8">
                    <a href="/" class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-flame">
                            <x-application-logo class="h-5 w-5 fill-current text-white" />
                        </span>
                        <span class="text-lg font-semibold text-true-black">FTS Menu</span>
                    </a>

                    <nav class="hidden items-center gap-8 text-body font-medium text-ink sm:flex">
                        <a href="#fitur" class="hover:text-smoke">Fitur</a>
                        <a href="#cara-kerja" class="hover:text-smoke">Cara Kerja</a>
                        <a href="#harga" class="hover:text-smoke">Harga</a>
                    </nav>

                    <div class="hidden items-center gap-3 sm:flex">
                        @auth
                            <a href="{{ route('dashboard.index') }}" class="inline-flex items-center justify-center rounded-pill bg-signal-blue px-5 py-2 text-body font-semibold text-white transition hover:bg-bright-blue">
                                Dashboard
                            </a>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="rounded-pill px-4 py-2 text-body font-medium text-ink transition hover:text-smoke">
                                    Login
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-pill bg-signal-blue px-5 py-2 text-body font-semibold text-white transition hover:bg-bright-blue">
                                    Daftar Gratis
                                </a>
                            @endif
                        @endauth
                    </div>

                    <button type="button" class="sm:hidden" @click="mobileNavOpen = !mobileNavOpen" aria-label="Buka menu navigasi">
                        <svg class="h-6 w-6 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        </svg>
                    </button>
                </div>

                <div x-show="mobileNavOpen" x-cloak class="border-t border-mist px-6 py-4 sm:hidden">
                    <nav class="flex flex-col gap-4 text-body font-medium text-ink">
                        <a href="#fitur" @click="mobileNavOpen = false">Fitur</a>
                        <a href="#cara-kerja" @click="mobileNavOpen = false">Cara Kerja</a>
                        <a href="#harga" @click="mobileNavOpen = false">Harga</a>
                        <div class="mt-2 flex flex-col gap-2">
                            @auth
                                <a href="{{ route('dashboard.index') }}" class="rounded-pill bg-signal-blue px-5 py-2 text-center font-semibold text-white">Dashboard</a>
                            @else
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="rounded-pill border border-silver px-5 py-2 text-center font-medium text-ink">Login</a>
                                @endif
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-pill bg-signal-blue px-5 py-2 text-center font-semibold text-white">Daftar Gratis</a>
                                @endif
                            @endauth
                        </div>
                    </nav>
                </div>
            </header>

            {{-- Hero --}}
            <section class="bg-pure-white">
                <div class="mx-auto grid max-w-page items-center gap-12 px-6 py-20 lg:grid-cols-2 lg:px-8 lg:py-32">
                    <div>
                        <span class="inline-flex items-center rounded-pill bg-snow-gray px-4 py-1.5 text-caption font-medium text-smoke">
                            Menu digital untuk restoran &amp; kafe
                        </span>
                        <h1 class="mt-6 text-heading font-bold tracking-tight text-ink lg:text-heading-lg">
                            Satu QR, menu selalu terbaru.
                        </h1>
                        <p class="mt-6 max-w-xl text-subheading text-smoke">
                            Ganti harga, foto, deskripsi, dan status ketersediaan menu langsung dari HP — tanpa cetak ulang. Pelanggan tinggal scan QR code di meja.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-pill bg-signal-blue px-6 py-3 text-body font-semibold text-white transition hover:bg-bright-blue">
                                    Daftar Gratis
                                </a>
                            @endif
                            <a href="#harga" class="inline-flex items-center justify-center rounded-pill border border-silver px-6 py-3 text-body font-medium text-ink transition hover:border-ink">
                                Lihat Paket Harga
                            </a>
                        </div>
                        <p class="mt-4 text-caption text-pewter">Gratis selamanya untuk paket Free — tanpa kartu kredit.</p>
                    </div>

                    {{-- Illustrative phone mockup --}}
                    <div class="flex justify-center lg:justify-end">
                        <div class="w-full max-w-[300px] rounded-container border border-mist bg-snow-gray p-3 shadow-ambient">
                            <div class="rounded-card bg-pure-white p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-heading-sm font-semibold text-ink">Kopi Senja</p>
                                        <p class="text-caption text-smoke">Kafe &amp; Resto</p>
                                    </div>
                                    <span class="inline-flex items-center rounded-pill bg-vivid-green/10 px-3 py-1 text-caption font-medium text-vivid-green">Buka</span>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <span class="rounded-pill bg-signal-blue px-3 py-1 text-caption font-medium text-white">Semua</span>
                                    <span class="rounded-pill border border-silver px-3 py-1 text-caption text-smoke">Makanan</span>
                                    <span class="rounded-pill border border-silver px-3 py-1 text-caption text-smoke">Minuman</span>
                                </div>

                                <div class="mt-4 space-y-3">
                                    <div class="flex items-center gap-3 rounded-card border border-mist p-3">
                                        <div class="h-12 w-12 shrink-0 rounded-lg bg-amber-flame"></div>
                                        <div class="flex-1">
                                            <p class="text-body font-medium text-ink">Nasi Goreng Senja</p>
                                            <p class="text-caption text-smoke">Rp28.000</p>
                                        </div>
                                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-vivid-green"></span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-card border border-mist p-3">
                                        <div class="h-12 w-12 shrink-0 rounded-lg bg-snow-gray"></div>
                                        <div class="flex-1">
                                            <p class="text-body font-medium text-ink">Es Kopi Gula Aren</p>
                                            <p class="text-caption text-smoke">Rp18.000</p>
                                        </div>
                                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-vivid-green"></span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-card border border-mist p-3 opacity-50">
                                        <div class="h-12 w-12 shrink-0 rounded-lg bg-snow-gray"></div>
                                        <div class="flex-1">
                                            <p class="text-body font-medium text-ink">Sate Ayam</p>
                                            <p class="text-caption text-smoke">Rp25.000</p>
                                        </div>
                                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-alert-red"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Value strip --}}
            <section class="border-y border-mist bg-snow-gray">
                <div class="mx-auto grid max-w-page gap-8 px-6 py-12 sm:grid-cols-3 lg:px-8">
                    <div>
                        <p class="text-heading-sm font-semibold text-ink">Tanpa cetak ulang</p>
                        <p class="mt-2 text-body text-smoke">Harga atau menu berubah? Update langsung dari dashboard, tanpa biaya cetak.</p>
                    </div>
                    <div>
                        <p class="text-heading-sm font-semibold text-ink">Update dalam hitungan detik</p>
                        <p class="mt-2 text-body text-smoke">Ubah status "Tersedia" jadi "Habis" real-time saat stok menipis.</p>
                    </div>
                    <div>
                        <p class="text-heading-sm font-semibold text-ink">Rapi di semua device</p>
                        <p class="mt-2 text-body text-smoke">Tampilan menu dioptimalkan untuk layar HP tempat pelanggan scan QR.</p>
                    </div>
                </div>
            </section>

            {{-- Features --}}
            <section id="fitur" class="bg-pure-white py-20 lg:py-28">
                <div class="mx-auto max-w-page px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="bg-amber-flame bg-clip-text text-heading font-bold text-transparent">
                            Semua yang restoran butuhkan
                        </h2>
                        <p class="mt-4 text-subheading text-smoke">
                            Satu dashboard untuk mengelola profil, kategori, menu, dan QR code restoran Anda.
                        </p>
                    </div>

                    <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @php
                            $features = [
                                ['title' => 'URL Menu Unik', 'desc' => 'Setiap restoran punya link sendiri, mis. menu.fts-tech.co.id/kopi-senja.'],
                                ['title' => 'QR Code Siap Cetak', 'desc' => 'Generate dan unduh QR code untuk ditempel di meja.'],
                                ['title' => 'Kelola Kategori & Menu', 'desc' => 'Atur urutan kategori dan item menu sesuai kebutuhan.'],
                                ['title' => 'Foto & Deskripsi', 'desc' => 'Tambahkan foto dan deskripsi untuk tiap menu item.'],
                                ['title' => 'Status Tersedia/Habis', 'desc' => 'Tandai menu yang habis tanpa menghapusnya dari daftar.'],
                                ['title' => 'WhatsApp & Social Links', 'desc' => 'Hubungkan menu ke WhatsApp, Instagram, dan Google Maps.'],
                            ];
                        @endphp

                        @foreach ($features as $feature)
                            <div class="rounded-card bg-snow-gray p-6 shadow-ambient">
                                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-signal-blue/10 text-signal-blue">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </span>
                                <p class="mt-4 text-heading-sm font-semibold text-ink">{{ $feature['title'] }}</p>
                                <p class="mt-2 text-body text-smoke">{{ $feature['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- How it works --}}
            <section id="cara-kerja" class="bg-snow-gray py-20 lg:py-28">
                <div class="mx-auto max-w-page px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-heading font-bold text-ink">Mulai dalam 3 langkah</h2>
                    </div>

                    <div class="mt-14 grid gap-8 sm:grid-cols-3">
                        @php
                            $steps = [
                                ['n' => '1', 'title' => 'Daftar & buat profil', 'desc' => 'Buat akun gratis dan isi profil restoran Anda.'],
                                ['n' => '2', 'title' => 'Isi kategori & menu', 'desc' => 'Tambahkan kategori, item menu, harga, dan foto.'],
                                ['n' => '3', 'title' => 'Cetak & tempel QR', 'desc' => 'Unduh QR code dan tempel di meja restoran.'],
                            ];
                        @endphp

                        @foreach ($steps as $step)
                            <div class="rounded-card bg-pure-white p-6 shadow-ambient">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-signal-blue text-body font-semibold text-white">
                                    {{ $step['n'] }}
                                </span>
                                <p class="mt-4 text-heading-sm font-semibold text-ink">{{ $step['title'] }}</p>
                                <p class="mt-2 text-body text-smoke">{{ $step['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Pricing --}}
            <section id="harga" class="bg-pure-white py-20 lg:py-28">
                <div class="mx-auto max-w-page px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-heading font-bold text-ink">Paket harga sederhana</h2>
                        <p class="mt-4 text-subheading text-smoke">Mulai gratis, upgrade kapan saja saat restoran berkembang.</p>
                    </div>

                    <div class="mt-14 grid gap-6 lg:grid-cols-4">
                        @php
                            $plans = [
                                [
                                    'name' => 'Free',
                                    'price' => 'Rp0',
                                    'period' => '/bulan',
                                    'desc' => 'Untuk mencoba tanpa risiko.',
                                    'features' => ['10 menu item', '3 kategori', 'URL & QR code', 'Foto menu terbatas'],
                                    'highlight' => false,
                                ],
                                [
                                    'name' => 'Starter',
                                    'price' => 'Rp49.000',
                                    'period' => '/bulan',
                                    'desc' => 'Warung modern & kafe kecil.',
                                    'features' => ['30 menu item', '10 kategori', 'Foto menu penuh', 'Status tersedia/habis'],
                                    'highlight' => false,
                                ],
                                [
                                    'name' => 'Business',
                                    'price' => 'Rp99.000',
                                    'period' => '/bulan',
                                    'desc' => 'Restoran aktif & menjaga branding.',
                                    'features' => ['100 menu item', 'Kategori unlimited', 'Custom warna tampilan', 'Statistik dasar', 'Tanpa branding FTS'],
                                    'highlight' => true,
                                ],
                                [
                                    'name' => 'Pro',
                                    'price' => 'Rp149.000',
                                    'period' => '/bulan',
                                    'desc' => 'Restoran wisata & pelanggan internasional.',
                                    'features' => ['Menu unlimited', 'Multilingual (2 bahasa)', 'Statistik lanjutan', 'Priority support'],
                                    'highlight' => false,
                                ],
                            ];
                        @endphp

                        @foreach ($plans as $plan)
                            <div @class([
                                'rounded-card p-6',
                                'bg-snow-gray shadow-ambient' => ! $plan['highlight'],
                                'bg-pure-white shadow-ambient ring-2 ring-signal-blue' => $plan['highlight'],
                            ])>
                                @if ($plan['highlight'])
                                    <span class="inline-flex rounded-pill bg-amber-flame px-3 py-1 text-caption font-semibold text-white">Paling Populer</span>
                                @endif
                                <p class="mt-3 text-heading-sm font-semibold text-ink">{{ $plan['name'] }}</p>
                                <p class="mt-1 text-caption text-smoke">{{ $plan['desc'] }}</p>
                                <p class="mt-4">
                                    <span class="text-heading font-bold text-ink">{{ $plan['price'] }}</span>
                                    <span class="text-caption text-smoke">{{ $plan['period'] }}</span>
                                </p>

                                <ul class="mt-6 space-y-2">
                                    @foreach ($plan['features'] as $item)
                                        <li class="flex items-start gap-2 text-body text-smoke">
                                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-vivid-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" @class([
                                        'mt-8 block rounded-pill px-5 py-2.5 text-center text-body font-semibold transition',
                                        'bg-signal-blue text-white hover:bg-bright-blue' => $plan['highlight'],
                                        'border border-silver text-ink hover:border-ink' => ! $plan['highlight'],
                                    ])>
                                        Mulai Sekarang
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <p class="mt-8 text-center text-caption text-pewter">
                        Ada juga paket tahunan dengan harga lebih hemat. Hubungi kami untuk detail.
                    </p>
                </div>
            </section>

            {{-- CTA banner --}}
            <section class="bg-snow-gray">
                <div class="mx-auto max-w-page px-6 py-16 text-center lg:px-8">
                    <h2 class="text-heading font-bold text-ink">Siap punya menu digital sendiri?</h2>
                    <p class="mx-auto mt-4 max-w-xl text-subheading text-smoke">
                        Daftar gratis hari ini, tanpa batas waktu dan tanpa kartu kredit.
                    </p>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mt-8 inline-flex items-center justify-center rounded-pill bg-signal-blue px-6 py-3 text-body font-semibold text-white transition hover:bg-bright-blue">
                            Daftar Gratis Sekarang
                        </a>
                    @endif
                </div>
            </section>

            {{-- Footer --}}
            <footer class="border-t border-mist bg-pure-white">
                <div class="mx-auto flex max-w-page flex-col items-center justify-between gap-4 px-6 py-8 text-caption text-pewter sm:flex-row lg:px-8">
                    <div class="flex items-center gap-2">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-amber-flame">
                            <x-application-logo class="h-4 w-4 fill-current text-white" />
                        </span>
                        <span class="font-medium text-smoke">FTS Menu</span>
                    </div>
                    <p>&copy; {{ date('Y') }} FTS Menu. Semua hak cipta dilindungi.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
