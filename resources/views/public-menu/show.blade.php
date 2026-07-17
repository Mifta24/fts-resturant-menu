<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurant->name }} &mdash; Menu</title>
    <meta name="description" content="{{ $restaurant->description }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased" x-data="{ activeCategory: {{ $categories->first()?->id ?? 'null' }} }">

    @if ($restaurant->cover_path)
        <div class="h-40 sm:h-56 w-full bg-cover bg-center" style="background-image: url('{{ Storage::url($restaurant->cover_path) }}')"></div>
    @endif

    <header class="max-w-2xl mx-auto px-4 relative {{ $restaurant->cover_path ? '-mt-8' : 'pt-6' }}">
        <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
            @if ($restaurant->logo_path)
                <img src="{{ Storage::url($restaurant->logo_path) }}" alt="{{ $restaurant->name }}" class="h-16 w-16 rounded-full object-cover border-2 border-white shadow shrink-0">
            @endif
            <div class="min-w-0">
                <h1 class="text-lg font-semibold truncate" style="{{ $restaurant->primary_color ? 'color:'.$restaurant->primary_color : '' }}">{{ $restaurant->name }}</h1>
                @if ($restaurant->description)
                    <p class="text-sm text-gray-500 line-clamp-2">{{ $restaurant->description }}</p>
                @endif
            </div>
        </div>

        @include('public-menu.partials.social-links', ['restaurant' => $restaurant])
    </header>

    @if ($categories->isEmpty())
        <div class="max-w-2xl mx-auto px-4 py-16 text-center text-gray-500">
            {{ __('Menu belum tersedia.') }}
        </div>
    @else
        @include('public-menu.partials.category-nav', ['categories' => $categories])

        <main class="max-w-2xl mx-auto px-4 pb-16 space-y-8 mt-4">
            @foreach ($categories as $category)
                <section id="category-{{ $category->id }}">
                    <h2 class="text-base font-semibold text-gray-800 mb-3">{{ $category->name }}</h2>

                    @if ($category->menuItems->isEmpty())
                        <p class="text-sm text-gray-400">{{ __('Belum ada menu di kategori ini.') }}</p>
                    @else
                        <div class="space-y-3">
                            @foreach ($category->menuItems as $item)
                                @include('public-menu.partials.menu-card', ['item' => $item])
                            @endforeach
                        </div>
                    @endif
                </section>
            @endforeach
        </main>
    @endif

    <footer class="text-center text-xs text-gray-400 pb-8">
        {{ __('Powered by Fujiyama Technology Solutions') }}
    </footer>

    <script
        src="https://relay.fts-tech.co.id/static/widget.js"
        data-site-key="fts_fts_menu_fts_tech_co_id_2a68804733777873cae3acd7381a9305"
        data-api-base="https://relay.fts-tech.co.id"
        data-block-redirect="true"
        data-geo="true"
    ></script>
</body>
</html>
