<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-snow-gray font-sans text-ink antialiased">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
            @include('layouts.navigation')

            <div class="flex min-w-0 flex-1 flex-col">
                <!-- Mobile top bar -->
                <div class="flex items-center justify-between gap-4 border-b border-mist bg-pure-white px-4 py-3 md:hidden">
                    <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-flame">
                            <x-application-logo class="h-4 w-4 fill-current text-pure-white" />
                        </span>
                        <span class="text-body font-semibold text-ink">FTS Menu</span>
                    </a>
                    <button @click="sidebarOpen = true" class="p-1 text-ink" aria-label="{{ __('Buka menu') }}">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"></path></svg>
                    </button>
                </div>

                @isset($header)
                    <header class="border-b border-mist bg-pure-white px-6 py-6 lg:px-10">
                        <div class="mx-auto max-w-page">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1">
                    <div class="mx-auto max-w-page px-6 py-8 lg:px-10 lg:py-10">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
