<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ensino extends Model
{
    use HasFactory;

    protected $table = 'ensinos';

    protected $fillable = [
        'curriculum_id',
        'disciplina',
        'instituicao',
        'ano',
    ];

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }
}
