<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoUnidadeOrganica extends Model
{
    use HasFactory;
     protected $table = 'cargounidadeorganicas';

    protected $fillable = [
        'curriculum_id',
        'cargo_tipo',
        'instituicao',
        'inicio',
        'fim',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
