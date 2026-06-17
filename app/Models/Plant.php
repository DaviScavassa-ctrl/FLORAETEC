<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_popular',
        'reino',
        'filo',
        'classe',
        'ordem',
        'familia',
        'genero',
        'especie',
        'regiao',
        'habitat',
        'porte',
        'epoca_reprodutiva',
        'beneficios',
        'maleficios',
        'poda',
        'curiosidades',
        'plantas_companheiras',
        'ameacada_extincao',
        'imagem_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ameacada_extincao' => 'boolean',
    ];

    /**
     * Alias para manter compatibilidade com as views que usam $plant->foto
     * (a view usa 'foto' mas a coluna no banco é 'imagem_path').
     */
    public function getFotoAttribute(): ?string
    {
        return $this->imagem_path;
    }
}
