<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrientacaoEstudante extends Model
{
    use HasFactory;

    protected $table = 'orientacao_estudantes';

    protected $fillable = [
        'curriculum_id',
        'pais',
        'tipo_orientacao',
        'nome_estudante',
        'ano_conclusao',
        'instituicao',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
