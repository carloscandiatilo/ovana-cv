<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoNivelUnidade extends Model
{
    use HasFactory;
    protected $table = 'cargonivelunidades';

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
