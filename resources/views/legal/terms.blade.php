<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Syarat & Ketentuan — {{ config('app.name', 'FTS Menu') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-pure-white font-sans text-ink antialiased">
        @include('legal.partials.header')

        <main class="mx-auto max-w-3xl px-6 py-16 lg:px-8 lg:py-20">
            <h1 class="text-heading font-bold text-ink">Syarat & Ketentuan</h1>
            <p class="mt-2 text-caption text-pewter">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>

            <div class="mt-10 space-y-8 text-body text-smoke">
                <p>
                    Dokumen ini adalah draf awal Syarat & Ketentuan penggunaan {{ config('app.name', 'FTS Menu') }} dan perlu
                    ditinjau oleh tim legal sebelum digunakan secara final. Dengan mendaftar dan menggunakan layanan ini,
                    Anda ("Restoran") menyetujui ketentuan di bawah.
                </p>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">1. Layanan</h2>
                    <p class="mt-2">
                        {{ config('app.name', 'FTS Menu') }} menyediakan platform menu digital berbasis QR code untuk restoran
                        dan kafe, termasuk pengelolaan kategori, item menu, foto, dan status ketersediaan.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">2. Akun & Tanggung Jawab Restoran</h2>
                    <p class="mt-2">
                        Restoran bertanggung jawab atas keakuratan data menu, harga, dan foto yang diunggah, serta menjaga
                        kerahasiaan kredensial akun. Kami berhak menonaktifkan akun yang menyalahgunakan layanan.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">3. Paket & Pembayaran</h2>
                    <p class="mt-2">
                        Paket Free tersedia tanpa biaya dengan batasan fitur. Paket berbayar ditagih sesuai siklus billing
                        (bulanan atau tahunan) yang dipilih. Pembayaran yang sudah diverifikasi tidak dapat dikembalikan
                        kecuali ditentukan lain oleh kebijakan refund yang berlaku.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">4. Penangguhan & Pengakhiran</h2>
                    <p class="mt-2">
                        Kami dapat menangguhkan atau menutup akun yang melanggar ketentuan ini atau menyalahgunakan
                        layanan. Restoran dapat berhenti menggunakan layanan kapan saja.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">5. Batasan Tanggung Jawab</h2>
                    <p class="mt-2">
                        Layanan disediakan "sebagaimana adanya". Kami tidak bertanggung jawab atas kerugian tidak
                        langsung yang timbul dari penggunaan atau ketidaktersediaan layanan.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">6. Perubahan Ketentuan</h2>
                    <p class="mt-2">
                        Ketentuan ini dapat diperbarui dari waktu ke waktu. Perubahan signifikan akan diinformasikan
                        melalui email atau dashboard.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">7. Kontak</h2>
                    <p class="mt-2">
                        Pertanyaan mengenai ketentuan ini dapat dikirim melalui halaman
                        <a href="{{ route('dashboard.feedback.index') }}" class="text-signal-blue hover:underline">Feedback</a>
                        di dashboard atau kontak resmi Fujiyama Technology Solutions.
                    </p>
                </section>
            </div>
        </main>

        @include('legal.partials.footer')
    </body>
</html>
