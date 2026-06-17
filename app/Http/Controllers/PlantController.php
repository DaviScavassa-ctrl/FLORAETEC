<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlantController extends Controller
{
    /**
     * Catálogo / index
     */
    public function index()
    {
        $plants = Plant::latest()->get();

        return view('plants.dashboard', compact('plants'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        return view('plants.create');
    }

    /**
     * Salvar nova planta
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_popular'        => 'required|string|max:255',
            'reino'               => 'nullable|string|max:255',
            'filo'                => 'nullable|string|max:255',
            'classe'              => 'nullable|string|max:255',
            'ordem'               => 'nullable|string|max:255',
            'familia'             => 'nullable|string|max:255',
            'genero'              => 'nullable|string|max:255',
            'especie'             => 'required|string|max:255',
            'regiao'              => 'nullable|string|max:255',
            'habitat'             => 'nullable|string|max:255',
            'porte'               => 'nullable|string|max:255',
            'epoca_reprodutiva'   => 'nullable|string|max:255',
            'beneficios'          => 'nullable|string',
            'maleficios'          => 'nullable|string',
            'poda'                => 'nullable|string',
            'curiosidades'         => 'nullable|string',
            'plantas_companheiras'=> 'nullable|string',
            'ameacada_extincao'   => 'nullable|boolean',
            'foto'                => 'nullable|image|max:5120',
        ]);

        // Renomeia 'curiosidade' → 'curiosidades' para bater com a coluna
        /*
        if (isset($validated['curiosidade'])) {
            $validated['curiosidades'] = $validated['curiosidade'];
            unset($validated['curiosidade']);
        }
        */

        // Upload da foto
        if ($request->hasFile('foto')) {
            $validated['imagem_path'] = $request->file('foto')->store('plants', 'public');
        }

        $validated['ameacada_extincao'] = $request->boolean('ameacada_extincao');

        Plant::create($validated);

        return redirect()->route('dashboard')->with('success', 'Planta cadastrada com sucesso!');
    }

    /**
     * Exibir detalhes de uma planta
     */
    public function show(Plant $plant)
    {
        return view('plants.show', compact('plant'));
    }

    /**
     * Formulário de edição
     */
    public function edit(Plant $plant)
    {
        return view('plants.create', compact('plant'));
    }

    /**
     * Atualizar planta
     */
    public function update(Request $request, Plant $plant)
    {
        $validated = $request->validate([
            'nome_popular'         => 'required|string|max:255',
            'reino'                => 'nullable|string|max:255',
            'filo'                 => 'nullable|string|max:255',
            'classe'               => 'nullable|string|max:255',
            'ordem'                => 'nullable|string|max:255',
            'familia'              => 'nullable|string|max:255',
            'genero'               => 'nullable|string|max:255',
            'especie'              => 'required|string|max:255',
            'regiao'               => 'nullable|string|max:255',
            'habitat'              => 'nullable|string|max:255',
            'porte'                => 'nullable|string|max:255',
            'epoca_reprodutiva'    => 'nullable|string|max:255',
            'beneficios'           => 'nullable|string',
            'maleficios'           => 'nullable|string',
            'poda'                 => 'nullable|string',
            'curiosidades'         => 'nullable|string',
            'plantas_companheiras' => 'nullable|string',
            'ameacada_extincao'    => 'nullable|boolean',
            'foto'                 => 'nullable|image|max:5120',
        ]);

        // TRAVA DE SEGURANÇA: Se vier vazio do formulário, mantém o que já estava no banco!
        foreach ($validated as $key => $value) {
            if (is_null($value) || $value === '') {
                if ($key !== 'foto') { // Ignora a foto nessa checagem
                    $validated[$key] = $plant->{$key};
                }
            }
        }

        // Upload da foto nova, se o usuário enviou uma
        if ($request->hasFile('foto')) {
            if ($plant->imagem_path) {
                Storage::disk('public')->delete($plant->imagem_path);
            }
            $validated['imagem_path'] = $request->file('foto')->store('plants', 'public');
        }

        $validated['ameacada_extincao'] = $request->boolean('ameacada_extincao');

        unset($validated['foto']);

        $plant->update($validated);

        return redirect()->route('plants.show', $plant)->with('success', 'Planta atualizada com sucesso!');
    }

    /**
     * Remover planta
     */
    public function destroy(Plant $plant)
    {
        if ($plant->imagem_path) {
            Storage::disk('public')->delete($plant->imagem_path);
        }

        $plant->delete();

        return redirect()->route('dashboard')->with('success', 'Planta removida com sucesso!');
    }
}
