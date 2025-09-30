<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReconhecimentoComunidadeCientifico extends Model
{
    use HasFactory;

    protected $table = 'reconhecimentocomunidadecientificos';

    protected $fillable = [
        'curriculum_id',
        'pais',
        'tipo_reconhecimento',
        'reconhecimento',
        'entidade_responsavel',
        'classificacao',
        'tipo_premio',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
