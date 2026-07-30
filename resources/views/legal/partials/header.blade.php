<header class="border-b border-mist bg-pure-white">
    <div class="mx-auto flex max-w-page items-center justify-between px-6 py-4 lg:px-8">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-flame">
                <x-application-logo class="h-5 w-5 fill-current text-white" />
            </span>
            <span class="text-lg font-semibold text-true-black">{{ config('app.name', 'FTS Menu') }}</span>
        </a>

        <a href="{{ url('/') }}" class="text-body font-medium text-ink hover:text-smoke">
            &larr; Kembali ke beranda
        </a>
    </div>
</header>
