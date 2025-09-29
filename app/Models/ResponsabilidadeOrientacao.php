<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsabilidadeOrientacao extends Model
{
    use HasFactory;

    protected $table = 'responsabilidade_orientacoes';

    protected $fillable = [
        'curriculum_id',
        'pais',
        'instituicao',
        'tipo_responsabilidade',
        'nome_estudante',
        'ano_conclusao',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
