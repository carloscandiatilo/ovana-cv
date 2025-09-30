<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

class ExtensaoResource
{
    public static function getFormSchema(): array
    {
        return [
            Section::make('Produção Normativa')
                ->description('Registos de produção normativa')
                ->schema([
                    Repeater::make('producaonormativas')
                        ->relationship('producaonormativas')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_contribuicao')->required(),
                            Forms\Components\TextInput::make('nome_projecto')->required(),
                            Forms\Components\TextInput::make('curso'),
                            Forms\Components\TextInput::make('natureza'),
                            Forms\Components\TextInput::make('area'),
                            Forms\Components\TextInput::make('instituicao'),
                            Forms\Components\TextInput::make('orgao_tutela'),
                            Forms\Components\TextInput::make('funcao'),
                            Forms\Components\TextInput::make('ano')->type('number')->maxLength(4),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Prestação de Serviço')
                ->description('Registos de prestação de serviço')
                ->schema([
                    Repeater::make('prestacaoservicos')
                        ->relationship('prestacaoservicos')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_acao')->required(),
                            Forms\Components\TextInput::make('nome_projecto')->required(),
                            Forms\Components\TextInput::make('curso'),
                            Forms\Components\TextInput::make('equipa'),
                            Forms\Components\TextInput::make('instituicao'),
                            Forms\Components\TextInput::make('instituicao_parceira'),
                            Forms\Components\TextInput::make('coordenador_projecto'),
                            Forms\Components\DatePicker::make('inicio'),
                            Forms\Components\DatePicker::make('fim'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Interação com Comunidade')
                ->description('Registos de interação com a comunidade')
                ->schema([
                    Repeater::make('interaccoescomunidade')
                        ->relationship('interaccoescomunidade')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_realizacao')->required(),
                            Forms\Components\TextInput::make('nome_projecto')->required(),
                            Forms\Components\TextInput::make('estrutura'),
                            Forms\Components\TextInput::make('equipa'),
                            Forms\Components\TextInput::make('funcao'),
                            Forms\Components\TextInput::make('local_realizacao'),
                            Forms\Components\TextInput::make('instituicao'),
                            Forms\Components\TextInput::make('instituicoes_envolvidas'),
                            Forms\Components\DatePicker::make('inicio'),
                            Forms\Components\DatePicker::make('fim'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            Section::make('Mobilização de Agente')
                ->description('Registos de mobilização de agentes')
                ->schema([
                    Repeater::make('mobilizacoesagente')
                        ->relationship('mobilizacoesagente')
                        ->schema([
                            Forms\Components\TextInput::make('tipo_acao')->required(),
                            Forms\Components\TextInput::make('instituicao_parceira'),
                            Forms\Components\TextInput::make('local_actividade'),
                            Forms\Components\TextInput::make('nome_mecanismo'),
                            Forms\Components\TextInput::make('ano')->type('number')->maxLength(4),
                            Forms\Components\TextInput::make('coordenador_protocolo'),
                            Forms\Components\TextInput::make('instituicao'),
                            Forms\Components\DatePicker::make('inicio'),
                            Forms\Components\DatePicker::make('fim'),
                            Forms\Components\TextInput::make('instituicoes_envolvidas'),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),
        ];
    }
}
