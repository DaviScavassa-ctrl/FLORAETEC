{{-- resources/views/plants/create.blade.php --}}
{{-- Reutilize este mesmo arquivo para edição passando $plant e alterando a action para route('plants.update', $plant) --}}
@extends('layouts.app')

@section('title', isset($plant) ? 'Editar ' . $plant->nome_popular : 'Nova Planta — PlantCare')

@push('styles')
<style>
    .drop-zone { transition: border-color 0.2s, background-color 0.2s; }
    .drop-zone.drag-over {
        border-color: #16a34a !important;
        background-color: #f0fdf4 !important;
    }
    .dark .drop-zone.drag-over { background-color: rgba(22,163,74,.1) !important; }

    /* Custom checkbox --*/
    .custom-check:checked { background-color: #16a34a; border-color: #16a34a; }
    .custom-check:focus    { box-shadow: 0 0 0 3px rgba(22,163,74,.25); }

    /* Input base --*/
    .field {
        @apply w-full px-4 py-3 rounded-xl border border-[#bbf7d0]
               dark:border-[#16a34a]/40 bg-white dark:bg-[#052e16]/60
               text-[#052e16] dark:text-[#f0fdf4]
               placeholder-[#166534]/40 dark:placeholder-[#bbf7d0]/30
               focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent
               transition-all duration-200 text-sm;
    }

    /* Section headings --*/
    .section-heading {
        @apply text-xs font-semibold uppercase tracking-widest text-[#16a34a] mb-4
               flex items-center gap-2;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#f0fdf4] dark:bg-[#052e16]">

    {{-- ── Page header ──────────────────────────────────────────────── --}}
    <div class="max-w-screen-lg mx-auto px-6 pt-8 pb-4">
        <nav class="flex items-center gap-2 text-sm text-[#166534]/60 dark:text-[#bbf7d0]/50 mb-4">
            <a href="{{ route('dashboard') }}" class="hover:text-[#16a34a] transition-colors">Catálogo</a>
            <svg class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#052e16] dark:text-[#f0fdf4] font-medium">
                {{ isset($plant) ? 'Editar planta' : 'Nova planta' }}
            </span>
        </nav>

        <h1 class="text-3xl font-bold text-[#052e16] dark:text-[#f0fdf4]">
            {{ isset($plant) ? 'Editar ' . $plant->nome_popular : 'Cadastrar nova planta' }}
        </h1>
        <p class="mt-1 text-sm text-[#166534]/70 dark:text-[#bbf7d0]/60">
            Preencha as informações botânicas completas da espécie.
        </p>
    </div>

    {{-- ── Form ────────────────────────────────────────────────────── --}}
    <form
        method="POST"
        action="{{ isset($plant) ? route('plants.update', $plant) : route('plants.store') }}"
        enctype="multipart/form-data"
        class="max-w-screen-lg mx-auto px-6 pb-16"
        id="plant-form"
    >
        @csrf
        @if(isset($plant)) @method('PUT') @endif

        {{-- ── Two-column layout ────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6 mt-6">

            {{-- ╔══════════════════════════════╗
                 ║  LEFT: Photo Upload          ║
                 ╚══════════════════════════════╝ --}}
            <div class="space-y-4">

                {{-- Drag & Drop zone --}}
                <div class="rounded-2xl border-2 border-[#bbf7d0] dark:border-[#16a34a]/30 bg-white dark:bg-[#052e16]/60 overflow-hidden">
                    <div
                        id="drop-zone"
                        class="drop-zone p-8 flex flex-col items-center justify-center gap-4 cursor-pointer min-h-[240px]"
                        onclick="document.getElementById('foto-input').click()"
                    >
                        {{-- Preview or placeholder --}}
                        <div id="preview-wrap" class="{{ isset($plant) && $plant->foto ? '' : 'hidden' }} w-full">
                            <img
                                id="img-preview"
                                src="{{ isset($plant) && $plant->foto ? asset('storage/'.$plant->foto) : '' }}"
                                alt="Preview"
                                class="w-full rounded-xl object-cover aspect-[4/3]"
                            />
                            <button type="button" onclick="clearPhoto(event)"
                                    class="mt-2 text-xs text-red-400 hover:text-red-600 transition-colors w-full text-center">
                                ✕ Remover foto
                            </button>
                        </div>

                        <div id="drop-placeholder" class="{{ isset($plant) && $plant->foto ? 'hidden' : '' }} flex flex-col items-center gap-3 text-center select-none">
                            <div class="w-16 h-16 rounded-full bg-[#dcfce7] dark:bg-[#16a34a]/20 flex items-center justify-center">
                                <svg class="w-8 h-8 text-[#16a34a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#052e16] dark:text-[#f0fdf4]">
                                    Arraste a foto aqui
                                </p>
                                <p class="text-xs text-[#166534]/60 dark:text-[#bbf7d0]/40 mt-0.5">
                                    ou clique para selecionar
                                </p>
                                <p class="text-[10px] text-[#166534]/40 dark:text-[#bbf7d0]/30 mt-1">
                                    JPG, PNG, WEBP — máx. 5 MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <input
                        type="file"
                        id="foto-input"
                        name="foto"
                        accept="image/*"
                        class="hidden"
                        onchange="handleFileSelect(this)"
                    />
                </div>

                @error('foto')
                <p class="text-xs text-red-500 -mt-2">{{ $message }}</p>
                @enderror

                {{-- Extinction checkbox — highlighted card --}}
                <div class="rounded-2xl p-5 bg-white dark:bg-[#052e16]/60 border border-[#dcfce7] dark:border-[#16a34a]/20">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input
                            type="checkbox"
                            name="ameacada_extincao"
                            id="ameacada_extincao"
                            value="1"
                            {{ isset($plant) && $plant->ameacada_extincao ? 'checked' : '' }}
                            class="custom-check mt-0.5 w-5 h-5 rounded border-[#bbf7d0] dark:border-[#16a34a]/40
                                   text-[#16a34a] focus:ring-0 cursor-pointer
                                   dark:bg-[#052e16] dark:checked:bg-[#16a34a]
                                   transition-colors duration-200"
                        />
                        <div>
                            <p class="text-sm font-semibold text-[#052e16] dark:text-[#f0fdf4] group-hover:text-[#16a34a] transition-colors">
                                Ameaçada de extinção
                            </p>
                            <p class="text-xs text-[#166534]/60 dark:text-[#bbf7d0]/50 mt-0.5 leading-relaxed">
                                Marque se a espécie consta em listas de risco de extinção.
                            </p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  RIGHT: All fields                                   ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div class="space-y-6">

                {{-- ── Names ──────────────────────────────────────── --}}
                <div class="rounded-2xl p-6 bg-white dark:bg-[#052e16]/60 border border-[#dcfce7] dark:border-[#16a34a]/20">
                    <h3 class="section-heading">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
                        </svg>
                        Identificação
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">Nome popular *</label>
                            <input type="text" name="nome_popular" required
                                   value="{{ old('nome_popular', $plant->nome_popular ?? '') }}"
                                   placeholder="ex: Hibisco"
                                   class="field @error('nome_popular') border-red-400 @enderror" />
                            @error('nome_popular')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">Espécie (nome científico) *</label>
                            <input type="text" name="especie" required
                                   value="{{ old('especie', $plant->especie ?? '') }}"
                                   placeholder="ex: Hibiscus rosa-sinensis"
                                   class="field italic @error('especie') border-red-400 @enderror" />
                            @error('especie')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- ── Taxonomy selects ────────────────────────────── --}}
                <div class="rounded-2xl p-6 bg-white dark:bg-[#052e16]/60 border border-[#dcfce7] dark:border-[#16a34a]/20">
                    <h3 class="section-heading">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Classificação Taxonômica
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                        @php
                        $taxonomyFields = [
                            'reino'  => ['label'=>'Reino',   'opts'=>['Plantae','Fungi','Animalia','Protista','Monera']],
                            'filo'   => ['label'=>'Filo',    'opts'=>['Tracheophyta','Magnoliophyta','Anthophyta','Bryophyta','Pteridophyta']],
                            'classe' => ['label'=>'Classe',  'opts'=>['Magnoliopsida','Liliopsida','Polypodiopsida','Pinopsida','Lycopodiopsida']],
                            'ordem'  => ['label'=>'Ordem',   'opts'=>['Lamiales','Fabales','Myrtales','Asterales','Rosales','Poales','Asparagales','Malvales','Brassicales','Vitales','Piperales','Polypodiales','Solanales','Caryophyllales']],
                            'familia'=> ['label'=>'Família', 'opts'=>['Bignoniaceae','Fabaceae','Myrtaceae','Asteraceae','Poaceae','Orchidaceae','Malvaceae','Caricaceae','Lamiaceae','Urticaceae','Cactaceae','Vitaceae','Malpighiaceae','Piperacaea','Pteridaceae']],
                            'genero' => ['label'=>'Gênero',  'opts'=>['Handroanthus','Leucaena','Psidium','Mikania','Dichondra','Dendrobium','Adiantum','Plectranthus','Pilea','Pereskia','Hibiscus','Carica','Sorghum','Paspalum','Desmodium','Tridax','Cissus','Malpighia','Piper']],
                        ];
                        @endphp

                        @foreach($taxonomyFields as $name => $meta)
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">
                                {{ $meta['label'] }}
                            </label>
                            <select name="{{ $name }}"
                                    class="field appearance-none cursor-pointer">
                                <option value="">— Selecione —</option>
                                @foreach($meta['opts'] as $opt)
                                <option value="{{ $opt }}"
                                    {{ old($name, $plant->{$name} ?? '') === $opt ? 'selected' : '' }}>
                                    {{ $opt }}
                                </option>
                                @endforeach
                                <option value="_outro">Outro (digitar)</option>
                            </select>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Habitat & Characteristics ──────────────────── --}}
                <div class="rounded-2xl p-6 bg-white dark:bg-[#052e16]/60 border border-[#dcfce7] dark:border-[#16a34a]/20">
                    <h3 class="section-heading">
                        🌍 Habitat & Características
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">Região</label>
                            <input type="text" name="regiao"
                                   value="{{ old('regiao', $plant->regiao ?? '') }}"
                                   placeholder="ex: América tropical"
                                   class="field" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">Habitat</label>
                            <input type="text" name="habitat"
                                   value="{{ old('habitat', $plant->habitat ?? '') }}"
                                   placeholder="ex: Florestas tropicais"
                                   class="field" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">Porte</label>
                            <input type="text" name="porte"
                                   value="{{ old('porte', $plant->porte ?? '') }}"
                                   placeholder="ex: 2m a 5m"
                                   class="field" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">Época reprodutiva</label>
                            <input type="text" name="epoca_reprodutiva"
                                   value="{{ old('epoca_reprodutiva', $plant->epoca_reprodutiva ?? '') }}"
                                   placeholder="ex: Primavera e verão"
                                   class="field" />
                        </div>
                    </div>
                </div>

                {{-- ── Textareas ───────────────────────────────────── --}}
                <div class="rounded-2xl p-6 bg-white dark:bg-[#052e16]/60 border border-[#dcfce7] dark:border-[#16a34a]/20">
                    <h3 class="section-heading">📝 Informações Detalhadas</h3>
                    <div class="space-y-5">

                        @php
                        $textareas = [
                            ['name'=>'beneficios',           'label'=>'Benefícios',           'rows'=>3, 'placeholder'=>'Descreva os benefícios medicinais, alimentares ou ecológicos...'],
                            ['name'=>'maleficios',           'label'=>'Malefícios',            'rows'=>3, 'placeholder'=>'Descreva riscos, toxicidade ou contraindicações...'],
                            ['name'=>'poda',                 'label'=>'Poda',                  'rows'=>2, 'placeholder'=>'Frequência e época ideal de poda...'],
                            ['name'=>'curiosidades',          'label'=>'Curiosidades',          'rows'=>3, 'placeholder'=>'Fatos curiosos sobre a espécie...'],
                            ['name'=>'plantas_companheiras', 'label'=>'Plantas Companheiras',  'rows'=>3, 'placeholder'=>'Espécies que combinam bem ou competem com esta planta...'],
                        ];
                        @endphp

                        @foreach($textareas as $ta)
                        <div>
                            <label class="block text-xs font-medium text-[#166534] dark:text-[#bbf7d0]/70 mb-1.5">
                                {{ $ta['label'] }}
                            </label>
                            <textarea
                                name="{{ $ta['name'] }}"
                                rows="{{ $ta['rows'] }}"
                                placeholder="{{ $ta['placeholder'] }}"
                                class="field resize-y leading-relaxed"
                            >{{ old($ta['name'], $plant->{$ta['name']} ?? '') }}</textarea>
                            @error($ta['name'])<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Submit bar ──────────────────────────────────── --}}
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 text-sm text-[#166534]/70 hover:text-[#16a34a] transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                        </svg>
                        Cancelar
                    </a>

                    <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white
                                   bg-[#16a34a] hover:bg-[#15803d] active:bg-[#166534]
                                   focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:ring-offset-2
                                   transition-all duration-200 shadow-sm hover:shadow-md group">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ isset($plant) ? 'Salvar alterações' : 'Cadastrar planta' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// ── Drag & Drop ───────────────────────────────────────────────────────
const zone = document.getElementById('drop-zone');

['dragenter','dragover'].forEach(evt =>
    zone.addEventListener(evt, e => { e.preventDefault(); zone.classList.add('drag-over'); })
);
['dragleave','drop'].forEach(evt =>
    zone.addEventListener(evt, e => { e.preventDefault(); zone.classList.remove('drag-over'); })
);

zone.addEventListener('drop', e => {
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('foto-input').files = dt.files;
        showPreview(file);
    }
});

function handleFileSelect(input) {
    if (input.files[0]) showPreview(input.files[0]);
}

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('img-preview').src = e.target.result;
        document.getElementById('preview-wrap').classList.remove('hidden');
        document.getElementById('drop-placeholder').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

function clearPhoto(e) {
    e.stopPropagation();
    document.getElementById('foto-input').value = '';
    document.getElementById('preview-wrap').classList.add('hidden');
    document.getElementById('drop-placeholder').classList.remove('hidden');
}

// ── "Outro" option on selects ────────────────────────────────────────
document.querySelectorAll('select').forEach(sel => {
    sel.addEventListener('change', function() {
        if (this.value !== '_outro') return;
        const custom = prompt('Digite o valor para ' + this.previousElementSibling.textContent.trim() + ':');
        if (custom && custom.trim()) {
            const opt = new Option(custom.trim(), custom.trim(), true, true);
            this.add(opt);
            this.value = custom.trim();
        } else {
            this.value = '';
        }
    });
});
</script>
@endpush
