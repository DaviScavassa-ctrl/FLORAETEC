{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'PlantCare')</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-[#f0fdf4] dark:bg-[#052e16] text-[#052e16] dark:text-[#f0fdf4] antialiased">

{{-- ── Top navigation bar ─────────────────────────────────────────── --}}
<header class="sticky top-0 z-20 bg-white/80 dark:bg-[#052e16]/80 backdrop-blur-md
               border-b border-[#dcfce7] dark:border-[#16a34a]/20">
    <div class="max-w-screen-xl mx-auto px-6 h-14 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
            <svg class="w-7 h-7 text-[#16a34a] group-hover:scale-110 transition-transform duration-200"
                 viewBox="0 0 80 80" fill="none">
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z"
                      fill="currentColor" opacity=".18"/>
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z"
                      stroke="currentColor" stroke-width="2.5" fill="none"/>
                <line x1="40" y1="72" x2="40" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M40 50 Q28 42 24 30" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                <path d="M40 44 Q52 36 55 26" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
            </svg>
            <span class="text-lg font-bold tracking-tight">PlantCare</span>
        </a>

        {{-- Nav links (desktop) --}}
        <nav class="hidden md:flex items-center gap-1">
            @php
            $navLinks = [
                ['route' => 'dashboard',     'label' => 'Catálogo'],
                ['route' => 'plants.create', 'label' => 'Cadastrar'],
            ];
            @endphp
            @foreach($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150
                      {{ request()->routeIs($link['route'])
                          ? 'bg-[#dcfce7] dark:bg-[#16a34a]/20 text-[#16a34a]'
                          : 'text-[#166534] dark:text-[#bbf7d0]/70 hover:bg-[#f0fdf4] dark:hover:bg-[#16a34a]/10 hover:text-[#16a34a]' }}">
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>

        {{-- Right: user menu + dark toggle --}}
        <div class="flex items-center gap-3">

            {{-- Dark mode toggle --}}
            <button id="dark-toggle"
                    class="w-8 h-8 rounded-lg flex items-center justify-center
                           text-[#166534]/60 dark:text-[#bbf7d0]/60
                           hover:bg-[#dcfce7] dark:hover:bg-[#16a34a]/20
                           transition-all duration-200"
                    title="Alternar tema">
                <svg class="w-4 h-4 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg class="w-4 h-4 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>

            {{-- User dropdown --}}
            @auth
            <div class="relative" id="user-menu-wrap">
                <button id="user-menu-btn"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-xl
                               bg-[#f0fdf4] dark:bg-[#16a34a]/10
                               border border-[#bbf7d0] dark:border-[#16a34a]/30
                               text-sm font-medium text-[#052e16] dark:text-[#f0fdf4]
                               hover:border-[#16a34a] transition-all duration-200">
                    <span class="w-6 h-6 rounded-full bg-[#16a34a] text-white text-xs flex items-center justify-center font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="hidden sm:inline max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                    <svg class="w-3.5 h-3.5 text-[#166534]/60 dark:text-[#bbf7d0]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div id="user-menu-dropdown"
                     class="hidden absolute right-0 mt-2 w-48 rounded-2xl shadow-lg overflow-hidden
                            bg-white dark:bg-[#052e16]
                            border border-[#dcfce7] dark:border-[#16a34a]/20
                            py-1 z-50">
                    <div class="px-4 py-2 border-b border-[#dcfce7] dark:border-[#16a34a]/10">
                        <p class="text-xs font-semibold text-[#052e16] dark:text-[#f0fdf4] truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-[10px] text-[#166534]/60 dark:text-[#bbf7d0]/40 truncate">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2 px-4 py-2 text-sm text-[#166534] dark:text-[#bbf7d0]/80
                              hover:bg-[#f0fdf4] dark:hover:bg-[#16a34a]/10 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500
                                       hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Sair
                        </button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold text-[#16a34a]
                      border border-[#16a34a] hover:bg-[#16a34a] hover:text-white
                      transition-all duration-200">
                Entrar
            </a>
            @endauth
        </div>
    </div>
</header>

{{-- ── Flash messages ──────────────────────────────────────────────── --}}
@if(session('success'))
<div class="max-w-screen-xl mx-auto px-6 pt-4" x-data="{ show: true }" x-show="show">
    <div class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl
                bg-[#dcfce7] dark:bg-[#16a34a]/20 text-[#166534] dark:text-[#bbf7d0]
                border border-[#bbf7d0] dark:border-[#16a34a]/30 text-sm font-medium">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-[#16a34a] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="text-[#166534]/50 hover:text-[#16a34a] transition-colors">✕</button>
    </div>
</div>
@endif

{{-- ── Main content ─────────────────────────────────────────────────── --}}
<main>
    @yield('content')
</main>

<script>
// Dark mode toggle
const html      = document.documentElement;
const darkBtn   = document.getElementById('dark-toggle');
const saved     = localStorage.getItem('plantcare-theme');
if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme:dark)').matches)) {
    html.classList.add('dark');
}
darkBtn?.addEventListener('click', () => {
    html.classList.toggle('dark');
    localStorage.setItem('plantcare-theme', html.classList.contains('dark') ? 'dark' : 'light');
});

// User menu dropdown
const menuBtn  = document.getElementById('user-menu-btn');
const menuDrop = document.getElementById('user-menu-dropdown');
menuBtn?.addEventListener('click', e => {
    e.stopPropagation();
    menuDrop.classList.toggle('hidden');
});
document.addEventListener('click', () => menuDrop?.classList.add('hidden'));
</script>

@stack('scripts')
</body>
</html>
