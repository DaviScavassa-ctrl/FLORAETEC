{{-- resources/views/plants/show.blade.php --}}
@extends('layouts.app')

@section('title', $plant->nome_popular . ' — PlantCare')

@push('styles')
<style>
    @keyframes fade-up { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .reveal { animation: fade-up 0.5s ease both; }
    .reveal-1 { animation-delay:.05s } .reveal-2 { animation-delay:.12s }
    .reveal-3 { animation-delay:.18s } .reveal-4 { animation-delay:.24s }
    .reveal-5 { animation-delay:.30s }

    .info-block {
        @apply rounded-2xl p-5 border bg-white dark:bg-[#052e16]/60 border-[#dcfce7] dark:border-[#16a34a]/20;
    }
    .taxonomy-row {
        display: grid;
        grid-template-columns: 110px 1fr;
        gap: 4px 16px;
        align-items: baseline;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#f0fdf4] dark:bg-[#052e16]">

    {{-- ── Breadcrumb nav ───────────────────────────────────────────── --}}
    <nav class="max-w-screen-lg mx-auto px-6 pt-6 pb-2">
        <ol class="flex items-center gap-2 text-sm text-[#166534]/60 dark:text-[#bbf7d0]/50">
            <li><a href="{{ route('dashboard') }}" class="hover:text-[#16a34a] transition-colors">Catálogo</a></li>
            <li>
                <svg class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </li>
            <li class="font-medium text-[#052e16] dark:text-[#f0fdf4]">{{ $plant->nome_popular }}</li>
        </ol>
    </nav>

    <div class="max-w-screen-lg mx-auto px-6 pb-16 space-y-8">

        {{-- ── Hero: photo + name ───────────────────────────────────── --}}
        <div class="reveal reveal-1 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

            {{-- Photo --}}
            <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-[#dcfce7] dark:bg-[#166534]/20 shadow-md">
                @if($plant->foto)
                    <img src="{{ asset('storage/' . $plant->foto) }}"
                         alt="{{ $plant->nome_popular }}"
                         class="w-full h-full object-cover"/>
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-24 h-24 text-[#16a34a]/30" viewBox="0 0 80 80" fill="none">
                            <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Name + quick facts --}}
            <div class="flex flex-col justify-between py-1">
                <div>
                    @if($plant->ameacada_extincao)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                                 bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 mb-3">
                        <span>⚠</span> Ameaçada de extinção
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                                 bg-[#dcfce7] dark:bg-[#16a34a]/20 text-[#166534] dark:text-[#bbf7d0] mb-3">
                        ✓ Não está em extinção
                    </span>
                    @endif

                    <h1 class="text-4xl font-bold text-[#052e16] dark:text-[#f0fdf4] leading-tight">
                        {{ $plant->nome_popular }}
                    </h1>
                    <p class="mt-1 text-lg italic text-[#166534]/70 dark:text-[#bbf7d0]/60">
                        {{ $plant->especie }}
                    </p>
                </div>

                {{-- Quick stats grid --}}
                <div class="grid grid-cols-2 gap-3 mt-6">
                    @php
                    $stats = [
                        ['label' => 'Porte',            'value' => $plant->porte,           'icon' => '📏'],
                        ['label' => 'Época reprodutiva', 'value' => $plant->epoca_reprodutiva,'icon' => '🌸'],
                        ['label' => 'Poda',             'value' => $plant->poda,            'icon' => '✂️'],
                        ['label' => 'Habitat',          'value' => $plant->habitat,         'icon' => '🌍'],
                    ];
                    @endphp
                    @foreach($stats as $s)
                    <div class="rounded-xl p-3 bg-white dark:bg-[#052e16]/60 border border-[#dcfce7] dark:border-[#16a34a]/20">
                        <div class="text-lg mb-0.5">{{ $s['icon'] }}</div>
                        <div class="text-xs font-semibold text-[#166534]/60 dark:text-[#bbf7d0]/50 uppercase tracking-wide">{{ $s['label'] }}</div>
                        <div class="text-sm font-medium text-[#052e16] dark:text-[#f0fdf4] mt-0.5 leading-snug">
                            {{ $s['value'] ?? '—' }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Taxonomy table ───────────────────────────────────────── --}}
        <div class="reveal reveal-2 info-block">
            <h2 class="text-sm font-semibold uppercase tracking-widest text-[#16a34a] mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Classificação Taxonômica
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-2.5">
                @php
                $taxonomy = [
                    'Reino'   => $plant->reino,
                    'Filo'    => $plant->filo,
                    'Classe'  => $plant->classe,
                    'Ordem'   => $plant->ordem,
                    'Família' => $plant->familia,
                    'Gênero'  => $plant->genero,
                    'Espécie' => $plant->especie,
                    'Região'  => $plant->regiao,
                ];
                @endphp
                @foreach($taxonomy as $key => $val)
                <div class="flex items-baseline gap-3 py-1.5 border-b border-[#f0fdf4] dark:border-[#16a34a]/10 last:border-0">
                    <span class="text-xs font-semibold text-[#166534]/60 dark:text-[#bbf7d0]/50 uppercase tracking-wide w-20 flex-shrink-0">{{ $key }}</span>
                    <span class="text-sm text-[#052e16] dark:text-[#f0fdf4] {{ in_array($key, ['Gênero', 'Espécie']) ? 'italic' : '' }}">
                        {{ $val ?? '—' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── Content sections ─────────────────────────────────────── --}}
        @php
        $sections = [
            ['key' => 'beneficios',           'label' => 'Benefícios',          'icon' => '💚', 'color' => 'green'],
            ['key' => 'maleficios',           'label' => 'Malefícios',          'icon' => '⚠️', 'color' => 'amber'],
            ['key' => 'curiosidades',         'label' => 'Curiosidade',         'icon' => '💡', 'color' => 'blue'],
            ['key' => 'plantas_companheiras','label' => 'Plantas Companheiras','icon' => '🌿', 'color' => 'green'],
        ];
        $colorMap = [
            'green' => 'bg-[#f0fdf4] dark:bg-[#16a34a]/10 border-[#bbf7d0] dark:border-[#16a34a]/30 text-[#166534] dark:text-[#bbf7d0]',
            'amber' => 'bg-amber-50 dark:bg-amber-500/10 border-amber-200 dark:border-amber-500/30 text-amber-800 dark:text-amber-300',
            'blue'  => 'bg-blue-50 dark:bg-blue-500/10 border-blue-200 dark:border-blue-500/30 text-blue-800 dark:text-blue-300',
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($sections as $idx => $sec)
            <div class="reveal reveal-{{ min($idx + 3, 5) }} rounded-2xl p-6 border {{ $colorMap[$sec['color']] }}">
                <h3 class="text-xs font-semibold uppercase tracking-widest mb-3 flex items-center gap-2 opacity-70">
                    <span>{{ $sec['icon'] }}</span>
                    {{ $sec['label'] }}
                </h3>
                <p class="text-sm leading-relaxed">
                    {{ $plant->{$sec['key']} ?? 'Informação não disponível.' }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- ── Actions ──────────────────────────────────────────────── --}}
        <div class="reveal reveal-5 flex items-center justify-between pt-2">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2 text-sm text-[#166534] dark:text-[#bbf7d0]/70 hover:text-[#16a34a] transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Voltar ao catálogo
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('plants.edit', $plant) }}"
                   class="px-4 py-2 rounded-xl border border-[#16a34a] text-[#16a34a] text-sm font-semibold
                          hover:bg-[#16a34a] hover:text-white transition-all duration-200">
                    Editar
                </a>

                <form method="POST" action="{{ route('plants.destroy', $plant) }}"
                      onsubmit="return confirm('Tem certeza que deseja remover {{ $plant->nome_popular }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 rounded-xl border border-red-300 text-red-500 text-sm font-semibold
                                   hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">
                        Remover
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
