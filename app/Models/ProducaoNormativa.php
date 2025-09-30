<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducaoNormativa extends Model
{
    use HasFactory;
    protected $table = 'producaonormativas';

    protected $fillable = [
        'curriculum_id',
        'tipo_contribuicao',
        'nome_projecto',
        'curso',
        'natureza',
        'area',
        'instituicao',
        'orgao_tutela',
        'funcao',
        'ano',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
