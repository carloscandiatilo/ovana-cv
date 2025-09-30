<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectoInvestigacao extends Model
{
    use HasFactory;
    protected $table = 'projectoinvestigacaos';

    protected $fillable = [
        'curriculum_id',
        'tipo_participacao',
        'nome_projecto',
        'objectivo',
        'instituicao',
        'membros_equipa',
        'inicio',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
