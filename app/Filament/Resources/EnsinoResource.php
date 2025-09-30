<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EnsinoResource
{
    /**
     * Retorna opções de país via API REST ou cache
     */
    public static function getCountryOptions(): array
    {
        return Cache::remember('all_countries', 3600, function () {
            try {
                $response = Http::get('https://restcountries.com/v3.1/all?fields=name');

                if (! $response->successful()) {
                    return [];
                }

                $countries = collect($response->json())
                    ->pluck('name.common')
                    ->unique()
                    ->sort()
                    ->values()
                    ->toArray();

                return array_combine($countries, $countries);
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    public static function getFormSchema(): array
    {
        $currentYear = date('Y');

        return [
            Section::make('Material Pedagógico')
                ->description('Registos de materiais pedagógicos do currículo')
                ->collapsed()
                ->schema([
                    Repeater::make('material_pedagogicos')
                        ->relationship('material_pedagogicos')
                        ->schema([
                            Select::make('tipo_material')
                                ->label('Tipo de Conteúdo')
                                ->options([
                                    'Livro de apoio ao ensino' => 'Livro de apoio ao ensino',
                                    'Reedição de livro de apoio ao ensino' => 'Reedição de livro de apoio ao ensino',
                                    'Texto pedagógico (sebenta/manual)' => 'Texto pedagógico (sebenta/manual)',
                                    'Artigo de natureza pedagógica publicado em revista indexada' => 'Artigo de natureza pedagógica publicado em revista indexada',
                                    'Artigo de natureza pedagógica publicado em revista não indexada' => 'Artigo de natureza pedagógica publicado em revista não indexada',
                                    'Capítulo de livro de apoio ao ensino' => 'Capítulo de livro de apoio ao ensino',
                                    'Aplicação informática, protótipo experimental, guia de laboratório' => 'Aplicação informática, protótipo experimental, guia de laboratório',
                                    'Reedição de texto pedagógico, sebenta ou manual' => 'Reedição de texto pedagógico, sebenta ou manual',
                                    'Artigo de natureza pedagógica publicado em acta de conferência internacional' => 'Artigo de natureza pedagógica publicado em acta de conferência internacional',
                                    'Artigo de natureza pedagógica publicado em acta de conferência nacional' => 'Artigo de natureza pedagógica publicado em acta de conferência nacional',
                                    'Texto didáctico sobre parte do programa' => 'Texto didáctico sobre parte do programa',
                                    'Material didáctico disponibilizado na internet' => 'Material didáctico disponibilizado na internet',
                                    'Comunicação de natureza pedagógica em evento internacional' => 'Comunicação de natureza pedagógica em evento internacional',
                                    'Comunicação de natureza pedagógica em evento nacional' => 'Comunicação de natureza pedagógica em evento nacional',
                                    'Outras publicações de natureza pedagógica' => 'Outras publicações de natureza pedagógica',
                                ])
                                ->searchable()
                                ->required(),

                            TextInput::make('ano_publicacao')
                                ->label('Ano de Publicação')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->maxLength(4),

                            TextInput::make('coautor')->label('Coautor')->maxLength(255),
                            TextInput::make('registro')->label('Registro')->maxLength(255),
                            TextInput::make('link')->label('Link')->url()->maxLength(255),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Material'),
                ]),

            Section::make('Orientação de Estudante')
                ->description('Registos de orientações de estudantes')
                ->collapsed()
                ->schema([
                    Repeater::make('orientacao_estudantes')
                        ->relationship('orientacao_estudantes')
                        ->schema([
                            Select::make('pais')
                                ->label('País')
                                ->options(fn() => self::getCountryOptions())
                                ->searchable()
                                ->required(),

                            Select::make('tipo_orientacao')
                                ->label('Tipo de Orientação')
                                ->options([
                                    'Orientação de tese de Doutoramento (concluída)' => 'Orientação de tese de Doutoramento (concluída)',
                                    'Orientação de dissertação de Mestrado (concluída)' => 'Orientação de dissertação de Mestrado (concluída)',
                                    'Orientação de trabalho de fim de curso de Licenciatura (concluído)' => 'Orientação de trabalho de fim de curso de Licenciatura (concluído)',
                                    'Orientação de tese de Doutoramento (em curso)' => 'Orientação de tese de Doutoramento (em curso)',
                                    'Orientação de dissertação de Mestrado (em curso)' => 'Orientação de dissertação de Mestrado (em curso)',
                                    'Orientação de trabalho de fim de curso de Licenciatura (em curso)' => 'Orientação de trabalho de fim de curso de Licenciatura (em curso)',
                                    'Orientação de estágio curricular de Licenciatura' => 'Orientação de estágio curricular de Licenciatura',
                                    'Orientação de outros trabalhos de natureza científico-pedagógica' => 'Orientação de outros trabalhos de natureza científico-pedagógica',
                                ])
                                ->searchable()
                                ->required(),

                            TextInput::make('nome_estudante')->label('Nome do Estudante')->required()->maxLength(255),
                            TextInput::make('ano_conclusao')
                                ->label('Ano de Conclusão')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->maxLength(4),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Orientação'),
                ]),

            Section::make('Responsabilidade de Orientação')
                ->description('Registos de responsabilidade em orientação')
                ->collapsed()
                ->schema([
                    Repeater::make('responsabilidade_orientacoes')
                        ->relationship('responsabilidade_orientacoes')
                        ->schema([
                            Select::make('pais')
                                ->label('País')
                                ->options(fn() => self::getCountryOptions())
                                ->searchable()
                                ->required(),

                            Select::make('tipo_responsabilidade')
                                ->label('Tipo de Responsabilidade')
                                ->options([
                                    'Orientador de tese de doutoramento' => 'Orientador de tese de doutoramento',
                                    'Co-Orientador de tese de doutoramento' => 'Co-Orientador de tese de doutoramento',
                                    'Orientador de dissertação de mestrado' => 'Orientador de dissertação de mestrado',
                                    'Co-Orientador de dissertação de mestrado' => 'Co-Orientador de dissertação de mestrado',
                                    'Orientador de trabalho de fim de curso de licenciatura' => 'Orientador de trabalho de fim de curso de licenciatura',
                                    'Co-Orientador de trabalho de fim de curso de licenciatura' => 'Co-Orientador de trabalho de fim de curso de licenciatura',
                                ])
                                ->searchable()
                                ->required(),

                            TextInput::make('nome_estudante')->label('Nome do Estudante')->required()->maxLength(255),
                            TextInput::make('ano_conclusao')
                                ->label('Ano de Conclusão')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->maxLength(4),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Responsabilidade'),
                ]),

            Section::make('Leccionação de Unidades Curriculares')
                ->description('Registos de leccionação')
                ->collapsed()
                ->schema([
                    Repeater::make('leccionacoes')
                        ->relationship('leccionacoes')
                        ->schema([
                            Select::make('tipo_participacao')
                                ->label('Tipo de Participação')
                                ->options([
                                    'Leccionação e regência de Unidades Curriculares' => 'Leccionação e regência de Unidades Curriculares',
                                    'Leccionação de Unidades Curriculares' => 'Leccionação de Unidades Curriculares',
                                    'Introdução de inovações pedagógicas no ensino' => 'Introdução de inovações pedagógicas no ensino',
                                    'Realização de workshop sobre temática do programa' => 'Realização de workshop sobre temática do programa',
                                    'Realização de visita de estudo relacionada com a UC' => 'Realização de visita de estudo relacionada com a UC',
                                    'Membro de comissão nacional de exame de fim de curso' => 'Membro de comissão nacional de exame de fim de curso',
                                    'Membro de júri de prova de exame final de curso' => 'Membro de júri de prova de exame final de curso',
                                    'Resultado da avaliação feita pelos estudantes' => 'Resultado da avaliação feita pelos estudantes',
                                ])
                                ->searchable()
                                ->required(),

                            TextInput::make('disciplina')->label('Disciplina')->required()->maxLength(255),
                            TextInput::make('ano')
                                ->label('Ano')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->maxLength(4),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                            Select::make('pais')
                                ->label('País')
                                ->options(fn() => self::getCountryOptions())
                                ->searchable(),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Leccionação'),
                ]),

            Section::make('Infra-Estrutura de Apoio ao Ensino')
                ->description('Registos de infraestrutura de ensino')
                ->collapsed()
                ->schema([
                    Repeater::make('infraestrutura_ensinos')
                        ->relationship('infraestrutura_ensinos')
                        ->schema([
                            Select::make('tipo_infraestrutura')
                                ->label('Tipo de Infraestrutura')
                                ->options([
                                    'Responsável por reforço de laboratório de apoio ao ensino' => 'Responsável por reforço de laboratório de apoio ao ensino',
                                    'Participação na criação de laboratório de apoio ao ensino' => 'Participação na criação de laboratório de apoio ao ensino',
                                    'Participação no reforço de laboratório de apoio ao ensino' => 'Participação no reforço de laboratório de apoio ao ensino',
                                    'Responsável por criação de plataforma electrónica de apoio ao ensino' => 'Responsável por criação de plataforma electrónica de apoio ao ensino',
                                    'Participação na criação de plataforma electrónica de apoio ao ensino' => 'Participação na criação de plataforma electrónica de apoio ao ensino',
                                    'Disponibilização de base de dados electrónica de bibliografia' => 'Disponibilização de base de dados electrónica de bibliografia',
                                ])
                                ->searchable()
                                ->required(),

                            TextInput::make('nome_lab_plataforma')->label('Nome do Laboratório/Plataforma')->required()->maxLength(255),
                            TextInput::make('registro_responsavel')->label('Registro Responsável')->maxLength(255),
                            TextInput::make('ano')
                                ->label('Ano')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->maxLength(4),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Infraestrutura'),
                ]),
        ];
    }
}
