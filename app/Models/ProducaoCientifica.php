<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducaoCientifica extends Model
{
    use HasFactory;
    protected $table = 'producaocientificas';

    protected $fillable = [
        'curriculum_id',
        'tipo_producao',
        'titulo',
        'ano_publicacao',
        'coautor',
        'registro',
        'editora',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
