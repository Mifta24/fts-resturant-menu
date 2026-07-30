<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kebijakan Privasi — {{ config('app.name', 'FTS Menu') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-pure-white font-sans text-ink antialiased">
        @include('legal.partials.header')

        <main class="mx-auto max-w-3xl px-6 py-16 lg:px-8 lg:py-20">
            <h1 class="text-heading font-bold text-ink">Kebijakan Privasi</h1>
            <p class="mt-2 text-caption text-pewter">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>

            <div class="mt-10 space-y-8 text-body text-smoke">
                <p>
                    Dokumen ini adalah draf awal Kebijakan Privasi {{ config('app.name', 'FTS Menu') }} dan perlu ditinjau
                    oleh tim legal sebelum digunakan secara final. Kebijakan ini menjelaskan bagaimana kami mengumpulkan,
                    menggunakan, dan melindungi data Anda.
                </p>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">1. Data yang Dikumpulkan</h2>
                    <p class="mt-2">
                        Kami mengumpulkan data akun (nama, email), data restoran (nama, deskripsi, kontak, foto), data
                        menu, serta data penggunaan seperti jumlah kunjungan menu (page view) untuk kebutuhan statistik.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">2. Penggunaan Data</h2>
                    <p class="mt-2">
                        Data digunakan untuk menjalankan layanan (menampilkan menu publik, autentikasi, penagihan),
                        mengirim notifikasi terkait akun dan langganan, serta meningkatkan kualitas layanan.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">3. Berbagi Data</h2>
                    <p class="mt-2">
                        Data menu dan profil restoran yang berstatus publikasi ditampilkan secara terbuka melalui URL
                        menu dan QR code. Kami tidak menjual data pribadi ke pihak ketiga.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">4. Penyimpanan & Keamanan</h2>
                    <p class="mt-2">
                        Data disimpan pada infrastruktur yang dilindungi kontrol akses dan enkripsi kredensial. Setiap
                        restoran hanya dapat mengakses data miliknya sendiri (tenant isolation).
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">5. Hak Pengguna</h2>
                    <p class="mt-2">
                        Anda dapat meminta koreksi atau penghapusan data akun dan restoran melalui halaman Feedback di
                        dashboard.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">6. Perubahan Kebijakan</h2>
                    <p class="mt-2">
                        Kebijakan ini dapat diperbarui dari waktu ke waktu. Perubahan signifikan akan diinformasikan
                        melalui email atau dashboard.
                    </p>
                </section>

                <section>
                    <h2 class="text-heading-sm font-semibold text-ink">7. Kontak</h2>
                    <p class="mt-2">
                        Pertanyaan mengenai kebijakan ini dapat dikirim melalui halaman
                        <a href="{{ route('dashboard.feedback.index') }}" class="text-signal-blue hover:underline">Feedback</a>
                        di dashboard atau kontak resmi Fujiyama Technology Solutions.
                    </p>
                </section>
            </div>
        </main>

        @include('legal.partials.footer')
    </body>
</html>
