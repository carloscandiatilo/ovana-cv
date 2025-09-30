<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfraestruturaInvestigacao extends Model
{
    use HasFactory;
    protected $table = 'infraestruturasinvestigacaos';

    protected $fillable = [
        'curriculum_id',
        'instituicao',
        'tipo_infraestrutura',
        'laboratorio',
        'nome_responsavel',
        'registro',
        'ano',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
