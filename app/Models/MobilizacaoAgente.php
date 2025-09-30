<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilizacaoAgente extends Model
{
    use HasFactory;
    protected $table = 'mobilizacoesagente';

    protected $fillable = [
        'curriculum_id',
        'tipo_acao',
        'instituicao_parceira',
        'local_actividade',
        'nome_mecanismo',
        'ano',
        'coordenador_protocolo',
        'instituicao',
        'inicio',
        'fim',
        'instituicoes_envolvidas',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
