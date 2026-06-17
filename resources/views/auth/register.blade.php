{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Criar conta — PlantCare</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        @keyframes float-slow { 0%,100%{transform:translateY(0) rotate(0deg)} 50%{transform:translateY(-18px) rotate(6deg)} }
        @keyframes float-med  { 0%,100%{transform:translateY(0) rotate(0deg)} 50%{transform:translateY(-12px) rotate(-4deg)} }
        .blob-1 { animation: float-slow 7s ease-in-out infinite; }
        .blob-2 { animation: float-med  5s ease-in-out infinite 1.5s; }
        .blob-3 { animation: float-slow 9s ease-in-out infinite 3s; }

        /* Password strength bar */
        #strength-bar { transition: width 0.4s ease, background-color 0.4s ease; }
    </style>
</head>
<body class="min-h-screen bg-[#f0fdf4] dark:bg-[#052e16] text-[#052e16] dark:text-[#f0fdf4] antialiased">

<div class="min-h-screen flex">

    {{-- ── Left panel ───────────────────────────────────────────────── --}}
    <div class="hidden lg:flex lg:w-2/5 relative overflow-hidden bg-[#052e16] flex-col items-center justify-center p-16">
        <div class="blob-1 absolute top-12 left-8 w-40 h-40 rounded-full bg-[#16a34a]/20 blur-2xl"></div>
        <div class="blob-2 absolute bottom-24 right-10 w-56 h-56 rounded-full bg-[#16a34a]/15 blur-3xl"></div>
        <div class="blob-3 absolute top-1/2 left-1/3 w-32 h-32 rounded-full bg-[#bbf7d0]/10 blur-xl"></div>

        <div class="relative z-10 flex flex-col items-center gap-6 text-center">
            <svg class="w-24 h-24 text-[#16a34a]" viewBox="0 0 80 80" fill="none">
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor" opacity=".18"/>
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" stroke="currentColor" stroke-width="2.5" fill="none"/>
                <line x1="40" y1="72" x2="40" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M40 50 Q28 42 24 30" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                <path d="M40 44 Q52 36 55 26" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
            </svg>
            <div>
                <h1 class="text-3xl font-bold text-white">Junte-se ao PlantCare</h1>
                <p class="mt-2 text-[#bbf7d0]/70 text-base leading-relaxed max-w-xs">
                    Crie sua conta e comece a monitorar seu jardim hoje mesmo.
                </p>
            </div>

            {{-- Benefits list --}}
            <ul class="space-y-3 mt-2 text-left">
                @foreach (['Catálogo com 20+ espécies documentadas', 'Alertas de rega e luminosidade', 'Histórico de crescimento das plantas', 'Dashboard personalizado'] as $benefit)
                <li class="flex items-center gap-3 text-sm text-[#bbf7d0]/80">
                    <span class="w-5 h-5 rounded-full bg-[#16a34a]/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-[#16a34a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    {{ $benefit }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- ── Right panel: register form ──────────────────────────────── --}}
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 lg:px-16 overflow-y-auto">

        {{-- Mobile logo --}}
        <div class="lg:hidden flex items-center gap-3 mb-8">
            <svg class="w-8 h-8 text-[#16a34a]" viewBox="0 0 80 80" fill="none">
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor" opacity=".2"/>
                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" stroke="currentColor" stroke-width="2.5" fill="none"/>
                <line x1="40" y1="72" x2="40" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="text-2xl font-bold">PlantCare</span>
        </div>

        <div class="w-full max-w-md">
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight">Criar sua conta</h2>
                <p class="mt-2 text-sm text-[#166534] dark:text-[#bbf7d0]/70">
                    Preencha os dados abaixo para começar.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium mb-1.5">Nome completo</label>
                    <input
                        id="name" type="text" name="name"
                        value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Maria Silva"
                        class="w-full px-4 py-3 rounded-xl border border-[#bbf7d0] dark:border-[#16a34a]/40
                               bg-white dark:bg-[#052e16]/60 text-[#052e16] dark:text-[#f0fdf4]
                               placeholder-[#166534]/40 dark:placeholder-[#bbf7d0]/30
                               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
                               transition-all duration-200
                               @error('name') border-red-400 @enderror"
                    />
                    @error('name')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium mb-1.5">E-mail</label>
                    <input
                        id="email" type="email" name="email"
                        value="{{ old('email') }}" required autocomplete="username"
                        placeholder="voce@email.com"
                        class="w-full px-4 py-3 rounded-xl border border-[#bbf7d0] dark:border-[#16a34a]/40
                               bg-white dark:bg-[#052e16]/60 text-[#052e16] dark:text-[#f0fdf4]
                               placeholder-[#166534]/40 dark:placeholder-[#bbf7d0]/30
                               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
                               transition-all duration-200
                               @error('email') border-red-400 @enderror"
                    />
                    @error('email')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium mb-1.5">Senha</label>
                    <input
                        id="password" type="password" name="password"
                        required autocomplete="new-password"
                        placeholder="Mínimo 8 caracteres"
                        oninput="checkStrength(this.value)"
                        class="w-full px-4 py-3 rounded-xl border border-[#bbf7d0] dark:border-[#16a34a]/40
                               bg-white dark:bg-[#052e16]/60 text-[#052e16] dark:text-[#f0fdf4]
                               placeholder-[#166534]/40 dark:placeholder-[#bbf7d0]/30
                               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
                               transition-all duration-200
                               @error('password') border-red-400 @enderror"
                    />
                    {{-- Strength indicator --}}
                    <div class="mt-2 h-1.5 bg-[#dcfce7] dark:bg-[#16a34a]/20 rounded-full overflow-hidden">
                        <div id="strength-bar" class="h-full w-0 rounded-full bg-[#16a34a]"></div>
                    </div>
                    <p id="strength-label" class="mt-1 text-xs text-[#166534]/60 dark:text-[#bbf7d0]/40"></p>
                    @error('password')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Password confirm --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirmar senha</label>
                    <input
                        id="password_confirmation" type="password" name="password_confirmation"
                        required autocomplete="new-password"
                        placeholder="Repita a senha"
                        class="w-full px-4 py-3 rounded-xl border border-[#bbf7d0] dark:border-[#16a34a]/40
                               bg-white dark:bg-[#052e16]/60 text-[#052e16] dark:text-[#f0fdf4]
                               placeholder-[#166534]/40 dark:placeholder-[#bbf7d0]/30
                               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
                               transition-all duration-200
                               @error('password_confirmation') border-red-400 @enderror"
                    />
                    @error('password_confirmation')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-3 px-6 rounded-xl font-semibold text-white mt-2
                           bg-[#16a34a] hover:bg-[#15803d] active:bg-[#166534]
                           focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:ring-offset-2
                           transition-all duration-200 shadow-sm hover:shadow-md
                           flex items-center justify-center gap-2 group"
                >
                    <span>Criar minha conta</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-[#166534] dark:text-[#bbf7d0]/70">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="font-semibold text-[#16a34a] hover:text-[#15803d] transition-colors ml-1">
                    Entrar
                </a>
            </p>
        </div>
    </div>
</div>

<script>
function checkStrength(val) {
    const bar   = document.getElementById('strength-bar');
    const label = document.getElementById('strength-label');
    let score = 0;
    if (val.length >= 8)  score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { w: '25%', color: '#ef4444', text: 'Muito fraca' },
        { w: '50%', color: '#f97316', text: 'Fraca' },
        { w: '75%', color: '#eab308', text: 'Boa' },
        { w: '100%', color: '#16a34a', text: 'Forte' },
    ];
    const l = levels[Math.max(0, score - 1)] || levels[0];
    bar.style.width = val.length ? l.w : '0';
    bar.style.backgroundColor = l.color;
    label.textContent = val.length ? l.text : '';
}
</script>
</body>
</html>
