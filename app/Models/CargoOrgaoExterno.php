<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoOrgaoExterno extends Model
{
    use HasFactory;
    protected $table = 'cargoorgaosexternos';

    protected $fillable = [
        'curriculum_id',
        'cargo_tipo',
        'entidade',
        'inicio',
        'fim',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
