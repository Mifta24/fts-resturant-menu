<nav class="sticky top-0 z-30 mt-5 border-y border-mist bg-pure-white/90 py-3 shadow-sm backdrop-blur">
    <div class="no-scrollbar mx-auto flex max-w-3xl gap-2 overflow-x-auto px-4 sm:px-6">
        @foreach ($categories as $category)
            <a
                href="#category-{{ $category->id }}"
                @click="activeCategory = {{ $category->id }}"
                :class="activeCategory === {{ $category->id }} ? 'border-transparent text-white shadow-sm' : 'border-silver bg-pure-white text-smoke hover:border-ink hover:text-ink'"
                :style="activeCategory === {{ $category->id }} ? 'background-color: var(--brand-color)' : ''"
                class="whitespace-nowrap rounded-pill border px-4 py-2 text-sm font-semibold transition"
            >
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</nav>
