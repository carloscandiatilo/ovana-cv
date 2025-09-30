<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteracaoComunidade extends Model
{
    use HasFactory;
    protected $table = 'interaccoescomunidade';

    protected $fillable = [
        'curriculum_id',
        'tipo_realizacao',
        'nome_projecto',
        'estrutura',
        'equipa',
        'funcao',
        'local_realizacao',
        'instituicao',
        'instituicoes_envolvidas',
        'inicio',
        'fim',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
