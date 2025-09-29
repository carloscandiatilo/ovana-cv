<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfraestruturaEnsino extends Model
{
    use HasFactory;

    protected $table = 'infraestrutura_ensinos';

    protected $fillable = [
        'curriculum_id',
        'instituicao',
        'tipo_infraestrutura',
        'nome_lab_plataforma',
        'registro_responsavel',
        'ano',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
