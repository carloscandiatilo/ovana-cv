<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPedagogico extends Model
{
    use HasFactory;

    protected $table = 'material_pedagogicos';

    protected $fillable = [
        'curriculum_id',
        'tipo_material',
        'ano_publicacao',
        'coautor',
        'registro',
        'link',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
