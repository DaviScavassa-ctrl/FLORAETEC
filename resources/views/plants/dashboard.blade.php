{{-- resources/views/plants/dashboard.blade.php --}}
{{-- Extends seu layout principal, ex: layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Catálogo de Plantas — PlantCare')

@push('styles')
<style>
    @keyframes card-in {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .plant-card { animation: card-in 0.4s ease both; }

    /* Stagger delays */
    .plant-card:nth-child(1)  { animation-delay: .05s }
    .plant-card:nth-child(2)  { animation-delay: .10s }
    .plant-card:nth-child(3)  { animation-delay: .15s }
    .plant-card:nth-child(4)  { animation-delay: .20s }
    .plant-card:nth-child(5)  { animation-delay: .25s }
    .plant-card:nth-child(6)  { animation-delay: .30s }
    .plant-card:nth-child(7)  { animation-delay: .35s }
    .plant-card:nth-child(8)  { animation-delay: .40s }
    .plant-card:nth-child(9)  { animation-delay: .45s }
    .plant-card:nth-child(10) { animation-delay: .50s }
    .plant-card:nth-child(n+11) { animation-delay: .55s }

    .card-image-wrap { overflow: hidden; }
    .card-image-wrap img { transition: transform 0.5s ease; }
    .plant-card:hover .card-image-wrap img { transform: scale(1.07); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#f0fdf4] dark:bg-[#052e16]">

    {{-- ── Header strip ─────────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-[#052e16]/80 border-b border-[#dcfce7] dark:border-[#16a34a]/20 sticky top-0 z-10 backdrop-blur-sm">
        <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between gap-4">

            {{-- Title --}}
            <div class="flex items-center gap-3">
                <svg class="w-7 h-7 text-[#16a34a]" viewBox="0 0 80 80" fill="none">
                    <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor" opacity=".2"/>
                    <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" stroke="currentColor" stroke-width="2.5" fill="none"/>
                    <line x1="40" y1="72" x2="40" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <div>
                    <h1 class="text-xl font-bold text-[#052e16] dark:text-[#f0fdf4] leading-none">Catálogo Botânico</h1>
                    <p class="text-xs text-[#166534] dark:text-[#bbf7d0]/60 mt-0.5">{{ $plants->count() }} espécies documentadas</p>
                </div>
            </div>

            {{-- Search + Add button --}}
            <div class="flex items-center gap-3">
                <div class="relative hidden sm:block">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#16a34a]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        id="search-input"
                        placeholder="Buscar planta..."
                        class="pl-9 pr-4 py-2 rounded-xl border border-[#bbf7d0] dark:border-[#16a34a]/30
                               bg-[#f0fdf4] dark:bg-[#052e16]/60 text-sm
                               text-[#052e16] dark:text-[#f0fdf4]
                               placeholder-[#166534]/50 dark:placeholder-[#bbf7d0]/30
                               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
                               w-52 transition-all"
                    />
                </div>

                <a href="{{ route('plants.create') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d]
                          text-white text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="hidden sm:inline">Nova Planta</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Filter bar ───────────────────────────────────────────────── --}}
    <div class="max-w-screen-xl mx-auto px-6 pt-6 pb-2 flex gap-2 flex-wrap">
        @foreach (['Todas', 'Medicinais', 'Ornamentais', 'Frutíferas', 'Em Risco'] as $filter)
        <button
            class="filter-btn px-3 py-1.5 rounded-full text-xs font-medium border transition-all duration-200
                   {{ $loop->first
                       ? 'bg-[#16a34a] text-white border-[#16a34a]'
                       : 'bg-white dark:bg-[#052e16]/60 text-[#166534] dark:text-[#bbf7d0]/70 border-[#bbf7d0] dark:border-[#16a34a]/30 hover:border-[#16a34a] hover:text-[#16a34a]' }}"
        >{{ $filter }}</button>
        @endforeach
    </div>

    {{-- ── Plants grid ──────────────────────────────────────────────── --}}
    <main class="max-w-screen-xl mx-auto px-6 py-6">
        <div id="plants-grid"
             class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">

            @forelse ($plants as $plant)
            {{--
                REGRA DE OURO: o <a> envolve o card INTEIRO.
                Qualquer clique em foto, nome, badge → navega para show.
            --}}
            <a href="{{ route('plants.show', $plant) }}"
               class="plant-card group relative flex flex-col rounded-2xl overflow-hidden
                      bg-white dark:bg-[#052e16]/60
                      border border-[#dcfce7] dark:border-[#16a34a]/20
                      shadow-sm hover:shadow-xl
                      transition-all duration-300 hover:-translate-y-1 hover:scale-[1.02]
                      focus:outline-none focus-visible:ring-2 focus-visible:ring-[#16a34a]"
               data-name="{{ strtolower($plant->nome_popular) }} {{ strtolower($plant->nome_cientifico) }}"
            >
                {{-- Photo --}}
                <div class="card-image-wrap aspect-[4/3] bg-[#dcfce7] dark:bg-[#166534]/30 relative">
                    @if($plant->foto)
                        <img
                            src="{{ asset('storage/' . $plant->foto) }}"
                            alt="{{ $plant->nome_popular }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        />
                    @else
                        {{-- Placeholder leaf --}}
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-14 h-14 text-[#16a34a]/40" viewBox="0 0 80 80" fill="none">
                                <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Extinction badge --}}
                    @if($plant->ameacada_extincao)
                    <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[10px] font-bold
                                 bg-red-500/90 text-white backdrop-blur-sm shadow">
                        ⚠ Em risco
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 p-3.5 flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-[#052e16] dark:text-[#f0fdf4] leading-tight
                               group-hover:text-[#16a34a] transition-colors line-clamp-1">
                        {{ $plant->nome_popular }}
                    </h3>
                    <p class="text-[11px] italic text-[#166534]/70 dark:text-[#bbf7d0]/50 line-clamp-1">
                        {{ $plant->especie }}
                    </p>

                    {{-- Family badge --}}
                    <span class="mt-auto inline-block self-start px-2 py-0.5 rounded-full text-[10px] font-medium
                                 bg-[#dcfce7] dark:bg-[#16a34a]/20 text-[#166534] dark:text-[#bbf7d0]/80">
                        {{ $plant->familia }}
                    </span>
                </div>

                {{-- Arrow hint on hover --}}
                <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <div class="w-6 h-6 rounded-full bg-[#16a34a] flex items-center justify-center shadow">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-5 text-center py-20 text-[#166534]/60 dark:text-[#bbf7d0]/40">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-30" viewBox="0 0 80 80" fill="none">
                    <path d="M40 72 C40 72 8 56 8 32 C8 16 22 8 40 8 C58 8 72 16 72 32 C72 56 40 72 40 72Z" fill="currentColor"/>
                </svg>
                <p class="text-lg font-medium">Nenhuma planta cadastrada ainda.</p>
                <a href="{{ route('plants.create') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#16a34a] text-white text-sm font-semibold hover:bg-[#15803d] transition-colors">
                    Adicionar primeira planta
                </a>
            </div>
            @endforelse
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
// Live search filter
const searchInput = document.getElementById('search-input');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('#plants-grid .plant-card').forEach(card => {
            const name = card.dataset.name || '';
            card.style.display = name.includes(q) ? '' : 'none';
        });
    });
}
</script>
@endpush
