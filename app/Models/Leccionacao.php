<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leccionacao extends Model
{
    use HasFactory;

    protected $table = 'leccionacoes';

    protected $fillable = [
        'curriculum_id',
        'pais',
        'instituicao',
        'tipo_participacao',
        'disciplina',
        'ano',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
