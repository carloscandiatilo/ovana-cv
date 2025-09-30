<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestacaoServico extends Model
{
    use HasFactory;
    protected $table = 'prestacaoservicos';

    protected $fillable = [
        'curriculum_id',
        'tipo_acao',
        'nome_projecto',
        'curso',
        'equipa',
        'instituicao',
        'instituicao_parceira',
        'coordenador_projecto',
        'inicio',
        'fim',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
