<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WizardResource\Sections;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

class EnsinoResource
{
    /**
     * Retorna o schema completo de todas as sections de Dados de Ensino
     */
    public static function getFormSchema(): array
    {
        return [
            Section::make('Material Pedagógico')
                ->description('Registos de materiais pedagógicos do currículo')
                ->schema([
                    Repeater::make('material_pedagogicos')
                        ->relationship('material_pedagogicos')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_material')->required(),
                            Forms\Components\TextInput::make('ano_publicacao')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('coautor'),
                            Forms\Components\TextInput::make('registro'),
                            Forms\Components\TextInput::make('link'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Orientação de Estudante')
                ->description('Registos de orientações de estudantes')
                ->schema([
                    Repeater::make('orientacao_estudantes')
                        ->relationship('orientacao_estudantes')
                        ->schema([
                            Forms\Components\TextInput::make('pais')->required(),
                            Forms\Components\TextInput::make('tipo_orientacao')->required(),
                            Forms\Components\TextInput::make('nome_estudante')->required(),
                            Forms\Components\TextInput::make('ano_conclusao')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('instituicao'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Responsabilidade de Orientação')
                ->description('Registos de responsabilidade em orientação')
                ->schema([
                    Repeater::make('responsabilidade_orientacoes')
                        ->relationship('responsabilidade_orientacoes')
                        ->schema([
                            Forms\Components\TextInput::make('pais')->required(),
                            Forms\Components\TextInput::make('tipo_responsabilidade')->required(),
                            Forms\Components\TextInput::make('nome_estudante')->required(),
                            Forms\Components\TextInput::make('ano_conclusao')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('instituicao'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Leccionação')
                ->description('Registos de leccionação')
                ->schema([
                    Repeater::make('leccionacoes')
                        ->relationship('leccionacoes')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_participacao')->required(),
                            Forms\Components\TextInput::make('disciplina')->required(),
                            Forms\Components\TextInput::make('ano')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('instituicao'),
                            Forms\Components\TextInput::make('pais'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Infraestrutura de Ensino')
                ->description('Registos de infraestrutura de ensino')
                ->schema([
                    Repeater::make('infraestrutura_ensinos')
                        ->relationship('infraestrutura_ensinos')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_infraestrutura')->required(),
                            Forms\Components\TextInput::make('nome_lab_plataforma')->required(),
                            Forms\Components\TextInput::make('registro_responsavel'),
                            Forms\Components\TextInput::make('ano')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('instituicao'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),
        ];
    }
}
