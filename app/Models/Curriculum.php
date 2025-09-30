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
        'status',
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

    // Removido relacionamento com ensinos
    // public function ensinos() { return $this->hasMany(\App\Models\Ensino::class); }

    public function material_pedagogicos() { return $this->hasMany(MaterialPedagogico::class); }
    public function orientacao_estudantes() { return $this->hasMany(OrientacaoEstudante::class); }
    public function responsabilidade_orientacoes() { return $this->hasMany(ResponsabilidadeOrientacao::class); }
    public function leccionacoes() { return $this->hasMany(Leccionacao::class); }
    public function infraestrutura_ensinos() { return $this->hasMany(InfraestruturaEnsino::class); }

    //PASSO 3
    public function producaocientificas() { return $this->hasMany(ProducaoCientifica::class); }
    public function producaotecnologicas() { return $this->hasMany(ProducaoTecnologica::class); }
    public function projectoinvestigacaos() { return $this->hasMany(ProjectoInvestigacao::class); }
    public function infraestruturasinvestigacaos() { return $this->hasMany(InfraestruturaInvestigacao::class); }
    public function reconhecimentocomunidadecientificos() { return $this->hasMany(ReconhecimentoComunidadeCientifico::class); }


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
