<footer class="border-t border-mist bg-pure-white">
    <div class="mx-auto flex max-w-page flex-col items-center justify-between gap-4 px-6 py-8 text-caption text-pewter sm:flex-row lg:px-8">
        <div class="flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-md bg-amber-flame">
                <x-application-logo class="h-4 w-4 fill-current text-white" />
            </span>
            <span class="font-medium text-smoke">{{ config('app.name', 'FTS Menu') }}</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('terms') }}" class="hover:text-smoke">Syarat & Ketentuan</a>
            <a href="{{ route('privacy') }}" class="hover:text-smoke">Kebijakan Privasi</a>
        </div>
        <p>&copy; {{ date('Y') }} Fujiyama Technology Solutions. Semua hak cipta dilindungi.</p>
    </div>
</footer>
