<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducaoTecnologica extends Model
{
    use HasFactory;
    protected $table = 'producaotecnologicas';

    protected $fillable = [
        'curriculum_id',
        'tipo_producao',
        'nome_producao',
        'pais',
        'ano',
        'registro',
        'coautor',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
