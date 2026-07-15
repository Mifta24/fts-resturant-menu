<nav class="sticky top-0 bg-gray-50/95 backdrop-blur border-b border-gray-200 mt-4 py-2">
    <div class="max-w-2xl mx-auto px-4 flex gap-2 overflow-x-auto no-scrollbar">
        @foreach ($categories as $category)
            <a href="#category-{{ $category->id }}" class="whitespace-nowrap text-sm font-medium px-3 py-1.5 rounded-full bg-white border border-gray-200 text-gray-700">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</nav>
