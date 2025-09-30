<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

class GestaoResource
{
    public static function getFormSchema(): array
    {
        return [
            Section::make('Cargo Unidade Orgânica')
                ->description('Registos de cargos em unidades orgânicas')
                ->schema([
                    Repeater::make('cargounidadeorganicas')
                        ->relationship('cargounidadeorganicas')
                        ->schema([
                            Forms\Components\TextInput::make('cargo_tipo')->required(),
                            Forms\Components\TextInput::make('instituicao')->required(),
                            Forms\Components\DatePicker::make('inicio'),
                            Forms\Components\DatePicker::make('fim'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Cargo Nível Unidade')
                ->description('Registos de cargos a nível de unidade')
                ->schema([
                    Repeater::make('cargonivelunidades')
                        ->relationship('cargonivelunidades')
                        ->schema([
                            Forms\Components\TextInput::make('cargo_tipo')->required(),
                            Forms\Components\TextInput::make('instituicao')->required(),
                            Forms\Components\DatePicker::make('inicio'),
                            Forms\Components\DatePicker::make('fim'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Cargo Tarefas Temporárias')
                ->description('Registos de cargos temporários')
                ->schema([
                    Repeater::make('cargotarefastemporarias')
                        ->relationship('cargotarefastemporarias')
                        ->schema([
                            Forms\Components\TextInput::make('cargo_tipo')->required(),
                            Forms\Components\TextInput::make('entidade')->required(),
                            Forms\Components\DatePicker::make('inicio'),
                            Forms\Components\DatePicker::make('fim'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Cargo Órgão Externo')
                ->description('Registos de cargos em órgãos externos')
                ->schema([
                    Repeater::make('cargoorgaosexternos')
                        ->relationship('cargoorgaosexternos')
                        ->schema([
                            Forms\Components\TextInput::make('cargo_tipo')->required(),
                            Forms\Components\TextInput::make('entidade')->required(),
                            Forms\Components\DatePicker::make('inicio'),
                            Forms\Components\DatePicker::make('fim'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),
        ];
    }
}
