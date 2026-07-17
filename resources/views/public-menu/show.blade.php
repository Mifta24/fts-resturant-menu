<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurant->name }} &mdash; Menu</title>
    <meta name="description" content="{{ $restaurant->description }}">
    <meta name="theme-color" content="{{ preg_match('/^#[0-9A-Fa-f]{6}$/', $restaurant->primary_color ?? '') ? $restaurant->primary_color : '#f06413' }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&amp;display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $brandColor = preg_match('/^#[0-9A-Fa-f]{6}$/', $restaurant->primary_color ?? '')
        ? $restaurant->primary_color
        : '#f06413';
    $restaurantInitials = collect(preg_split('/\s+/', trim($restaurant->name)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('');
@endphp
<body
    class="min-h-screen bg-snow-gray font-sans text-ink antialiased"
    style="--brand-color: {{ $brandColor }}"
    x-data="{
        activeCategory: {{ $categories->first()?->id ?? 'null' }},
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) this.activeCategory = Number(entry.target.dataset.menuCategory);
                });
            }, { rootMargin: '-96px 0px -65% 0px' });

            this.$nextTick(() => {
                document.querySelectorAll('[data-menu-category]').forEach((section) => observer.observe(section));
            });
        }
    }"
>
    <div class="mx-auto min-h-screen max-w-5xl bg-snow-gray shadow-ambient">
        <div class="relative h-52 overflow-hidden sm:h-72">
            @if ($restaurant->cover_path)
                <img src="{{ Storage::url($restaurant->cover_path) }}" alt="Suasana {{ $restaurant->name }}" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-ink/45 via-transparent to-ink/10"></div>
            @else
                <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $brandColor }} 0%, #feab30 100%)"></div>
                <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full bg-white/15"></div>
                <div class="absolute -bottom-24 -left-16 h-56 w-56 rounded-full bg-ink/10"></div>
            @endif

            <a href="/" class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-pill bg-pure-white/90 px-3 py-2 text-xs font-semibold text-ink shadow-sm backdrop-blur transition hover:bg-pure-white sm:left-6 sm:top-6" aria-label="Tentang FTS Menu">
                <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-amber-flame text-[10px] font-bold text-white">FTS</span>
                Menu Digital
            </a>
        </div>

        <header class="relative z-10 mx-auto -mt-12 max-w-3xl px-4 sm:-mt-16 sm:px-6">
            <div class="rounded-container border border-mist bg-pure-white p-5 shadow-ambient sm:p-6">
                <div class="flex items-start gap-4 sm:gap-5">
                    @if ($restaurant->logo_path)
                        <img src="{{ Storage::url($restaurant->logo_path) }}" alt="Logo {{ $restaurant->name }}" class="h-20 w-20 shrink-0 rounded-card border-4 border-pure-white object-cover shadow-sm sm:h-24 sm:w-24">
                    @else
                        <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-card border-4 border-pure-white text-xl font-bold text-white shadow-sm sm:h-24 sm:w-24" style="background-color: {{ $brandColor }}">
                            {{ $restaurantInitials ?: 'RM' }}
                        </div>
                    @endif

                    <div class="min-w-0 flex-1 pt-1">
                        <p class="mb-1 text-xs font-semibold uppercase tracking-[0.14em] text-pewter">Menu digital</p>
                        <h1 class="text-heading-sm font-bold leading-tight sm:text-3xl" style="color: {{ $brandColor }}">{{ $restaurant->name }}</h1>

                        @if ($restaurant->description)
                            <p class="mt-2 text-sm leading-5 text-smoke sm:text-body">{{ $restaurant->description }}</p>
                        @endif
                    </div>
                </div>

                @if ($restaurant->address)
                    <div class="mt-4 flex items-start gap-2 border-t border-mist pt-4 text-sm text-smoke">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                            <circle cx="12" cy="10" r="2.5" />
                        </svg>
                        <span>{{ $restaurant->address }}</span>
                    </div>
                @endif

                @include('public-menu.partials.social-links', ['restaurant' => $restaurant])
            </div>
        </header>

        @if ($categories->isEmpty())
            <main class="mx-auto max-w-3xl px-4 py-16 text-center sm:px-6">
                <div class="rounded-container border border-mist bg-pure-white px-6 py-14 shadow-sm">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-snow-gray text-smoke">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5" />
                        </svg>
                    </span>
                    <h2 class="mt-4 text-heading-sm font-semibold text-ink">{{ __('Menu belum tersedia') }}</h2>
                    <p class="mt-2 text-body text-smoke">{{ __('Silakan kembali lagi nanti untuk melihat menu terbaru.') }}</p>
                </div>
            </main>
        @else
            @include('public-menu.partials.category-nav', ['categories' => $categories])

            <main class="mx-auto max-w-3xl space-y-10 px-4 pb-20 pt-8 sm:px-6">
                @foreach ($categories as $category)
                    <section id="category-{{ $category->id }}" data-menu-category="{{ $category->id }}" class="scroll-mt-24">
                        <div class="mb-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-pewter">Pilihan menu</p>
                                <h2 class="mt-1 text-heading-sm font-semibold text-ink">{{ $category->name }}</h2>
                            </div>
                            @unless ($category->menuItems->isEmpty())
                                <span class="shrink-0 rounded-pill bg-pure-white px-3 py-1 text-xs font-medium text-smoke shadow-sm">
                                    {{ $category->menuItems->count() }} item
                                </span>
                            @endunless
                        </div>

                        @if ($category->menuItems->isEmpty())
                            <div class="rounded-card border border-dashed border-silver bg-pure-white/60 px-5 py-8 text-center text-sm text-smoke">
                                {{ __('Belum ada menu di kategori ini.') }}
                            </div>
                        @else
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ($category->menuItems as $item)
                                    @include('public-menu.partials.menu-card', ['item' => $item])
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endforeach
            </main>
        @endif

        <footer class="border-t border-mist bg-pure-white px-4 py-8 text-center">
            <a href="/" class="inline-flex items-center gap-2 text-xs font-medium text-smoke transition hover:text-ink">
                <span>{{ __('Powered by') }}</span>
                <span class="font-bold text-ink">Fujiyama Technology Solutions</span>
            </a>
        </footer>
    </div>

    <script
        src="https://relay.fts-tech.co.id/static/widget.js"
        data-site-key="fts_fts_menu_fts_tech_co_id_2a68804733777873cae3acd7381a9305"
        data-api-base="https://relay.fts-tech.co.id"
        data-block-redirect="true"
        data-geo="true"
    ></script>
</body>
</html>
