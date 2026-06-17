{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Entrar — PlantCare</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --green-50:  #f0fdf4;
            --green-100: #dcfce7;
            --green-200: #bbf7d0;
            --green-600: #16a34a;
            --green-700: #15803d;
            --green-800: #166534;
            --green-950: #052e16;
        }
        body { font-family: 'Instrument Sans', sans-serif; }

        /* Animated leaf blobs */
        @keyframes float-slow  { 0%,100%{transform:translateY(0) rotate(0deg)} 50%{transform:translateY(-18px) rotate(6deg)} }
        @keyframes float-med   { 0%,100%{transform:translateY(0) rotate(0deg)} 50%{transform:translateY(-12px) rotate(-4deg)} }
        .blob-1 { animation: float-slow 7s ease-in-out infinite; }
        .blob-2 { animation: float-med  5s ease-in-out infinite 1.5s; }
        .blob-3 { animation: float-slow 9s ease-in-out infinite 3s; }
    </style>
</head>
<body class="h-full bg-[#f0fdf4] dark:bg-[#052e16] text-[#052e16] dark:text-[#f0fdf4] antialiased">

<div class="min-h-screen flex">

    {{-- ── Left panel: decorative green ──────────────────────────── --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[#052e16] flex-col items-center justify-center p-16">

        {{-- Floating abstract blobs --}}
        <div class="blob-1 absolute top-12 left-8 w-40 h-40 rounded-full bg-[#16a34a]/20 blur-2xl"></div>
        <div class="blob-2 absolute bottom-24 right-10 w-56 h-56 rounded-full bg-[#16a34a]/15 blur-3xl"></div>
        <div class="blob-3 absolute top-1/2 left-1/3 w-32 h-32 rounded-full bg-[#bbf7d0]/10 blur-xl"></div>

        {{-- Central leaf SVG --}}
        <div class="relative z-10 flex flex-col items-center gap-8">
            <svg class="w-28 h-28 text-[#16a34a]" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor" opacity=".18"/>
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" stroke="currentColor" stroke-width="2.5" fill="none"/>
                <line x1="40" y1="72" x2="40" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M40 50 Q28 42 24 30" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                <path d="M40 44 Q52 36 55 26" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
            </svg>

            <div class="text-center">
                <h1 class="text-4xl font-bold text-white tracking-tight">PlantCare</h1>
                <p class="mt-3 text-[#bbf7d0]/80 text-lg leading-relaxed max-w-xs">
                    Seu jardim digital. Monitore, cuide e aprenda sobre cada planta.
                </p>
            </div>

            {{-- Mini stats --}}
            <div class="grid grid-cols-3 gap-6 mt-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#16a34a]">20+</div>
                    <div class="text-xs text-[#bbf7d0]/60 mt-1">Espécies</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#16a34a]">100%</div>
                    <div class="text-xs text-[#bbf7d0]/60 mt-1">Botânico</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#16a34a]">∞</div>
                    <div class="text-xs text-[#bbf7d0]/60 mt-1">Cuidados</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right panel: login form ─────────────────────────────────── --}}
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 lg:px-16">

        {{-- Mobile logo --}}
        <div class="lg:hidden flex items-center gap-3 mb-10">
            <svg class="w-8 h-8 text-[#16a34a]" viewBox="0 0 80 80" fill="none">
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor" opacity=".2"/>
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" stroke="currentColor" stroke-width="2.5" fill="none"/>
                <line x1="40" y1="72" x2="40" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="text-2xl font-bold text-[#052e16] dark:text-[#f0fdf4]">PlantCare</span>
        </div>

        <div class="w-full max-w-md">
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight">Bem-vindo de volta</h2>
                <p class="mt-2 text-sm text-[#166534] dark:text-[#bbf7d0]/70">
                    Entre na sua conta para acessar seu jardim.
                </p>
            </div>

            {{-- Session status --}}
            @if (session('status'))
                <div class="mb-4 text-sm text-[#16a34a] font-medium bg-[#dcfce7] dark:bg-[#16a34a]/20 rounded-xl px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium mb-1.5">
                        E-mail
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl border border-[#bbf7d0] dark:border-[#16a34a]/40
                               bg-white dark:bg-[#052e16]/60
                               text-[#052e16] dark:text-[#f0fdf4]
                               placeholder-[#166534]/40 dark:placeholder-[#bbf7d0]/30
                               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
                               transition-all duration-200
                               @error('email') border-red-400 @enderror"
                        placeholder="voce@email.com"
                    />
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium">Senha</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-[#16a34a] hover:text-[#15803d] font-medium transition-colors">
                                Esqueceu a senha?
                            </a>
                        @endif
                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-xl border border-[#bbf7d0] dark:border-[#16a34a]/40
                               bg-white dark:bg-[#052e16]/60
                               text-[#052e16] dark:text-[#f0fdf4]
                               placeholder-[#166534]/40 dark:placeholder-[#bbf7d0]/30
                               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
                               transition-all duration-200
                               @error('password') border-red-400 @enderror"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2.5">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded border-[#bbf7d0] text-[#16a34a]
                               focus:ring-[#16a34a] focus:ring-offset-0
                               checked:bg-[#16a34a] checked:border-[#16a34a]
                               dark:border-[#16a34a]/40 dark:bg-[#052e16]"
                    />
                    <label for="remember_me" class="text-sm text-[#166534] dark:text-[#bbf7d0]/70 select-none cursor-pointer">
                        Lembrar de mim
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-3 px-6 rounded-xl font-semibold text-white
                           bg-[#16a34a] hover:bg-[#15803d] active:bg-[#166534]
                           focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:ring-offset-2
                           transition-all duration-200 shadow-sm hover:shadow-md
                           flex items-center justify-center gap-2 group"
                >
                    <span>Entrar no PlantCare</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>

            @if (Route::has('register'))
                <p class="mt-6 text-center text-sm text-[#166534] dark:text-[#bbf7d0]/70">
                    Ainda não tem conta?
                    <a href="{{ route('register') }}"
                       class="font-semibold text-[#16a34a] hover:text-[#15803d] transition-colors ml-1">
                        Cadastre-se grátis
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>

</body>
</html>
