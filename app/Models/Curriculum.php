<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'user_id',
        'avatar',
        'pessoal',
        'formacoes_academicas',
        'formacoes_complementares',
        'premios',
        'actuacoes_profissionais',
        'actuacoes_docencias',
        'investigacoes_cientificas',
        'extensoes_universitarias',
        'captacoes_financiamentos',
    ];

    protected $casts = [
        'pessoal' => 'array',
        'formacoes_academicas' => 'array',
        'formacoes_complementares' => 'array',
        'premios' => 'array',
        'actuacoes_profissionais' => 'array',
        'actuacoes_docencias' => 'array',
        'investigacoes_cientificas' => 'array',
        'extensoes_universitarias' => 'array',
        'captacoes_financiamentos' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function idiomas(): BelongsToMany
    {
        return $this->belongsToMany(Idioma::class, 'curriculum_idioma');
    }

    public function scopeAprovado($query)
    {
        return $query->where('status', 'aprovado');
    }

    /**
     * Garante que sempre associe o currículo ao usuário logado
     */
    protected static function booted()
    {
        static::creating(function ($curriculum) {
            if (! $curriculum->user_id) {
                $curriculum->user_id = auth()->id();
            }
        });
    }
}
