<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

class InvestigacaoResource
{
    public static function getFormSchema(): array
    {
        return [
            Section::make('Produção Científica')
                ->description('Registos de produção científica')
                ->schema([
                    Repeater::make('producaocientificas')
                        ->relationship('producaocientificas')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_producao')->required(),
                            Forms\Components\TextInput::make('titulo')->required(),
                            Forms\Components\TextInput::make('ano_publicacao')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('coautor'),
                            Forms\Components\TextInput::make('registro'),
                            Forms\Components\TextInput::make('editora'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Produção Tecnológica')
                ->description('Registos de produção tecnológica')
                ->schema([
                    Repeater::make('producaotecnologicas')
                        ->relationship('producaotecnologicas')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_producao')->required(),
                            Forms\Components\TextInput::make('nome_producao')->required(),
                            Forms\Components\TextInput::make('pais'),
                            Forms\Components\TextInput::make('ano')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('registro'),
                            Forms\Components\TextInput::make('coautor'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Projetos de Investigação')
                ->description('Registos de projetos de investigação')
                ->schema([
                    Repeater::make('projectoinvestigacaos')
                        ->relationship('projectoinvestigacaos')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_participacao')->required(),
                            Forms\Components\TextInput::make('nome_projecto')->required(),
                            Forms\Components\Textarea::make('objectivo'),
                            Forms\Components\TextInput::make('instituicao'),
                            Forms\Components\Textarea::make('membros_equipa'),
                            Forms\Components\DatePicker::make('inicio'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Infraestrutura de Investigação')
                ->description('Registos de infraestrutura de investigação')
                ->schema([
                    Repeater::make('infraestruturasinvestigacaos')
                        ->relationship('infraestruturasinvestigacaos')
                        ->schema([
                            Forms\Components\TextInput::make('instituicao')->required(),
                            Forms\Components\TextInput::make('tipo_infraestrutura')->required(),
                            Forms\Components\TextInput::make('laboratorio')->required(),
                            Forms\Components\TextInput::make('nome_responsavel')->required(),
                            Forms\Components\TextInput::make('registro'),
                            Forms\Components\TextInput::make('ano')->type('number')->maxLength(4),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Reconhecimento na Comunidade Científica')
                ->description('Registos de reconhecimento')
                ->schema([
                    Repeater::make('reconhecimentocomunidadecientificos')
                        ->relationship('reconhecimentocomunidadecientificos')
                        ->schema([
                            Forms\Components\TextInput::make('pais')->required(),
                            Forms\Components\TextInput::make('tipo_reconhecimento')->required(),
                            Forms\Components\TextInput::make('reconhecimento')->required(),
                            Forms\Components\TextInput::make('entidade_responsavel'),
                            Forms\Components\TextInput::make('classificacao'),
                            Forms\Components\TextInput::make('tipo_premio'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),
        ];
    }
}
