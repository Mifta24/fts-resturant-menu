@php
    $hasRestaurant = (bool) Auth::user()?->currentRestaurant();
    $isSuperAdmin = (bool) Auth::user()?->is_super_admin;
@endphp

<!-- Mobile overlay -->
<div
    x-show="sidebarOpen"
    x-transition:enter="transition-opacity ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-40 bg-ink/50 md:hidden"
    style="display: none;"
    @click="sidebarOpen = false"
></div>

<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    class="fixed inset-y-0 left-0 z-50 flex w-72 shrink-0 transform flex-col bg-pure-white transition-transform duration-200 ease-in-out md:static md:z-auto md:translate-x-0 md:border-r md:border-mist"
>
    <div class="flex h-20 items-center justify-between gap-3 px-6">
        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-flame">
                <x-application-logo class="h-5 w-5 fill-current text-pure-white" />
            </span>
            <span class="text-subheading font-semibold text-ink">FTS Menu</span>
        </a>
        <button @click="sidebarOpen = false" class="p-1 text-smoke md:hidden" aria-label="{{ __('Tutup menu') }}">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M6 18L18 6"></path></svg>
        </button>
    </div>

    <nav class="flex-1 space-y-6 overflow-y-auto px-4 pb-4">
        @if ($hasRestaurant)
            <div class="space-y-1">
                <p class="px-3 text-caption font-medium uppercase tracking-wide text-pewter">{{ __('Restoran') }}</p>

                <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3.75" y="3.75" width="7" height="7" rx="1.5"></rect><rect x="13.25" y="3.75" width="7" height="7" rx="1.5"></rect><rect x="3.75" y="13.25" width="7" height="7" rx="1.5"></rect><rect x="13.25" y="13.25" width="7" height="7" rx="1.5"></rect></svg>
                    <span>{{ __('Dashboard') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('dashboard.profile.edit')" :active="request()->routeIs('dashboard.profile.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 9.75 5 4.5h14l1.25 5.25"></path><path d="M4.5 9.75v9a.75.75 0 0 0 .75.75h13.5a.75.75 0 0 0 .75-.75v-9"></path><path d="M9.75 19.5v-5.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v5.25"></path></svg>
                    <span>{{ __('Profil Restoran') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('dashboard.categories.index')" :active="request()->routeIs('dashboard.categories.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11.03 3.75H6.75A2.25 2.25 0 0 0 4.5 6v4.28a2.25 2.25 0 0 0 .659 1.591l7.5 7.5a2.25 2.25 0 0 0 3.182 0l4.28-4.28a2.25 2.25 0 0 0 0-3.182l-7.5-7.5a2.25 2.25 0 0 0-1.591-.659Z"></path><circle cx="9" cy="9" r="1.25"></circle></svg>
                    <span>{{ __('Kategori') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('dashboard.menu-items.index')" :active="request()->routeIs('dashboard.menu-items.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 6.75h15"></path><path d="M4.5 12h15"></path><path d="M4.5 17.25h9"></path></svg>
                    <span>{{ __('Menu') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('dashboard.qr-code.show')" :active="request()->routeIs('dashboard.qr-code.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3.75" y="3.75" width="6" height="6" rx="1"></rect><rect x="14.25" y="3.75" width="6" height="6" rx="1"></rect><rect x="3.75" y="14.25" width="6" height="6" rx="1"></rect><rect x="14.25" y="14.25" width="2.5" height="2.5"></rect><rect x="17.75" y="14.25" width="2.5" height="2.5"></rect><rect x="14.25" y="17.75" width="2.5" height="2.5"></rect><rect x="17.75" y="17.75" width="2.5" height="2.5"></rect></svg>
                    <span>{{ __('QR Code') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('dashboard.analytics.index')" :active="request()->routeIs('dashboard.analytics.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5.25 19.5v-5.25"></path><path d="M12 19.5V8.25"></path><path d="M18.75 19.5v-9"></path></svg>
                    <span>{{ __('Statistik') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('dashboard.subscription.show')" :active="request()->routeIs('dashboard.subscription.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3.75" y="6" width="16.5" height="12" rx="1.5"></rect><path d="M3.75 10.5h16.5"></path></svg>
                    <span>{{ __('Langganan') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('dashboard.feedback.index')" :active="request()->routeIs('dashboard.feedback.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 5.25h15a1.5 1.5 0 0 1 1.5 1.5v8.25a1.5 1.5 0 0 1-1.5 1.5H9l-4.5 3.75V16.5H4.5a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5Z"></path></svg>
                    <span>{{ __('Feedback') }}</span>
                </x-nav-link>
            </div>
        @endif

        @if ($isSuperAdmin)
            <div class="space-y-1">
                <p class="px-3 text-caption font-medium uppercase tracking-wide text-pewter">{{ __('Admin') }}</p>

                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3.75" y="3.75" width="7" height="7" rx="1.5"></rect><rect x="13.25" y="3.75" width="7" height="7" rx="1.5"></rect><rect x="3.75" y="13.25" width="7" height="7" rx="1.5"></rect><rect x="13.25" y="13.25" width="7" height="7" rx="1.5"></rect></svg>
                    <span>{{ __('Dashboard') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('admin.restaurants.index')" :active="request()->routeIs('admin.restaurants.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 9.75 5 4.5h14l1.25 5.25"></path><path d="M4.5 9.75v9a.75.75 0 0 0 .75.75h13.5a.75.75 0 0 0 .75-.75v-9"></path><path d="M9.75 19.5v-5.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v5.25"></path></svg>
                    <span>{{ __('Restoran') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('admin.packages.index')" :active="request()->routeIs('admin.packages.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3.75" y="8.25" width="16.5" height="12" rx="1"></rect><path d="M3.75 12h16.5"></path><path d="M12 8.25v12"></path></svg>
                    <span>{{ __('Paket') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('admin.subscriptions.index')" :active="request()->routeIs('admin.subscriptions.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3.75" y="6" width="16.5" height="12" rx="1.5"></rect><path d="M3.75 10.5h16.5"></path></svg>
                    <span>{{ __('Langganan') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2.25" y="6.75" width="19.5" height="10.5" rx="1.5"></rect><circle cx="12" cy="12" r="2.25"></circle></svg>
                    <span>{{ __('Pembayaran') }}</span>
                </x-nav-link>
                <x-nav-link :href="route('admin.feedback.index')" :active="request()->routeIs('admin.feedback.*')">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 5.25h15a1.5 1.5 0 0 1 1.5 1.5v8.25a1.5 1.5 0 0 1-1.5 1.5H9l-4.5 3.75V16.5H4.5a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5Z"></path></svg>
                    <span>{{ __('Feedback') }}</span>
                </x-nav-link>
            </div>
        @endif
    </nav>

    <div class="border-t border-mist p-4">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-snow-gray">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-snow-gray text-sm font-semibold text-ink">
                {{ Illuminate\Support\Str::upper(Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
            </span>
            <span class="min-w-0">
                <span class="block truncate text-sm font-medium text-ink">{{ Auth::user()->name }}</span>
                <span class="block truncate text-caption text-smoke">{{ Auth::user()->email }}</span>
            </span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-smoke transition hover:bg-snow-gray hover:text-alert-red">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5.25H6.75A1.5 1.5 0 0 0 5.25 6.75v10.5a1.5 1.5 0 0 0 1.5 1.5H9"></path><path d="M14.25 15.75 18 12l-3.75-3.75"></path><path d="M18 12H9"></path></svg>
                <span>{{ __('Keluar') }}</span>
            </button>
        </form>
    </div>
</aside>
