<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Rules\AfterOrEqualField; // ← Adicionado para consistência e futuro uso

class InvestigacaoResource
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
            Section::make('Produção Científica')
                ->description('Registos de produção científica')
                ->collapsed()
                ->schema([
                    Repeater::make('producaocientificas')
                        ->relationship('producaocientificas')
                        ->schema([
                            Select::make('tipo_producao')
                                ->label('Tipo de Produção Científica')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Livro baseado em resultados de I&D, como autor'=>'Livro baseado em resultados de I&D, como autor',
                                    'Artigo em revista científica internacional indexada tipo A, como autor'=>'Artigo em revista científica internacional indexada tipo A, como autor',
                                    'Artigo em revista científica internacional indexada tipo B, como autor'=>'Artigo em revista científica internacional indexada tipo B, como autor',
                                    'Livro baseado em resultados de I&D, como co-autor'=>'Livro baseado em resultados de I&D, como co-autor',
                                    'Artigo em acta de conferência internacional tipo A'=>'Artigo em acta de conferência internacional tipo A',
                                    'Artigo em revista científica internacional indexada tipo A, como co-autor'=>'Artigo em revista científica internacional indexada tipo A, como co-autor',
                                    'Tese de Doutoramento concluída'=>'Tese de Doutoramento concluída',
                                    'Artigo em acta de conferência internacional tipo B'=>'Artigo em acta de conferência internacional tipo B',
                                    'Capítulo de livro baseado em resultados de I&D, como autor'=>'Capítulo de livro baseado em resultados de I&D, como autor',
                                    'Artigo em revista científica internacional indexada tipo B, como co-autor'=>'Artigo em revista científica internacional indexada tipo B, como co-autor',
                                    'Edição de livro baseado em resultados de I&D (editor ou organizador)'=>'Edição de livro baseado em resultados de I&D (editor ou organizador)',
                                    'Edição de "Edição Especial" em revista científica internacional indexada'=>'Edição de "Edição Especial" em revista científica internacional indexada',
                                    'Artigo em revista científica internacional não indexada'=>'Artigo em revista científica internacional não indexada',
                                    'Capítulo de livro baseado em resultados de I&D, como co-autor'=>'Capítulo de livro baseado em resultados de I&D, como co-autor',
                                    'Artigo em revista científica nacional'=>'Artigo em revista científica nacional',
                                    'Edição de acta de conferência internacional com ISBN (como organizador)'=>'Edição de acta de conferência internacional com ISBN (como organizador)',
                                    'Comunicação oral em evento científico internacional'=>'Comunicação oral em evento científico internacional',
                                    'Apresentação de poster em evento científico internacional'=>'Apresentação de poster em evento científico internacional',
                                    'Comunicação oral em evento científico nacional'=>'Comunicação oral em evento científico nacional',
                                    'Apresentação de poster em evento científico nacional'=>'Apresentação de poster em evento científico nacional',
                                    'Artigo em acta de conferência nacional'=>'Artigo em acta de conferência nacional',
                                    'Relatório final de projecto de investigação científica'=>'Relatório final de projecto de investigação científica',
                                    'Relatório de progresso de projecto de investigação científica'=>'Relatório de progresso de projecto de investigação científica',
                                ]),
                            TextInput::make('titulo')->required(),
                            TextInput::make('ano_publicacao')
                                ->label('Ano de Publicação')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules(['nullable','integer','min:1900','max:'.$currentYear]),
                            TextInput::make('coautor'),
                            TextInput::make('registro'),
                            TextInput::make('editora'),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn() => self::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2),
                ]),

            Section::make('Produção Tecnológica')
                ->description('Registos de produção tecnológica')
                ->collapsed()
                ->schema([
                    Repeater::make('producaotecnologicas')
                        ->relationship('producaotecnologicas')
                        ->schema([
                            Select::make('tipo_producao')
                                ->label('Tipo de Produção Tecnológica')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Patente internacional'=>'Patente internacional',
                                    'Modelo internacional'=>'Modelo internacional',
                                    'Desenho industrial internacional'=>'Desenho industrial internacional',
                                    'Desenho de protótipo'=>'Desenho de protótipo',
                                    'Patente registada no estrangeiro'=>'Patente registada no estrangeiro',
                                    'Desenho industrial nacional'=>'Desenho industrial nacional',
                                    'Patente registada no país'=>'Patente registada no país',
                                    'Registo de marcas'=>'Registo de marcas',
                                    'Software desenvolvido e registado e em utilização no mercado'=>'Software desenvolvido e registado e em utilização no mercado',
                                    'Software desenvolvido e registado'=>'Software desenvolvido e registado',
                                    'Nova tecnologia desenvolvida e registada'=>'Nova tecnologia desenvolvida e registada',
                                    'Direitos de autor registados'=>'Direitos de autor registados',
                                    'Modelo nacional'=>'Modelo nacional',
                                    'Novos processos e procedimentos desenvolvidos e registados'=>'Novos processos e procedimentos desenvolvidos e registados',
                                ]),
                            TextInput::make('nome_producao')->required(),
                            TextInput::make('registro'),
                            TextInput::make('coautor'),
                            TextInput::make('ano')
                                ->label('Ano')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules(['nullable','integer','min:1900','max:'.$currentYear]),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn() => self::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2),
                ]),

            Section::make('Projetos de Investigação')
                ->description('Registos de projetos de investigação')
                ->collapsed()
                ->schema([
                    Repeater::make('projectoinvestigacaos')
                        ->relationship('projectoinvestigacaos')
                        ->schema([
                            Select::make('tipo_participacao')
                                ->label('Tipo de Participação')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Responsável geral de projecto de I&D internacional'=>'Responsável geral de projecto de I&D internacional',
                                    'Responsável local de projecto de I&D internacional'=>'Responsável local de projecto de I&D internacional',
                                    'Avaliador de projectos de investigação científica internacional'=>'Avaliador de projectos de investigação científica internacional',
                                    'Supervisão de trabalhos de Pós-Doutoramento'=>'Supervisão de trabalhos de Pós-Doutoramento',
                                    'Aprovação em prova de doutoramento em universidade estrangeira'=>'Aprovação em prova de doutoramento em universidade estrangeira',
                                    'Responsável de projecto de I&D nacional'=>'Responsável de projecto de I&D nacional',
                                    'Participante em projecto de I&D internacional'=>'Participante em projecto de I&D internacional',
                                    'Aprovação em prova de doutoramento em universidade nacional'=>'Aprovação em prova de doutoramento em universidade nacional',
                                    'Aprovação em prova pública de competência científica e aptidão pedagógica'=>'Aprovação em prova pública de competência científica e aptidão pedagógica',
                                    'Avaliador de projectos de investigação científica nacional'=>'Avaliador de projectos de investigação científica nacional',
                                    'Participante em projecto de I&D nacional'=>'Participante em projecto de I&D nacional',
                                ]),
                            TextInput::make('nome_projecto')->label('Nome Projecto')->required(),
                            Textarea::make('objectivo')->label('Objectivo'),
                            TextInput::make('instituicao')->label('Instituição'),
                            TextInput::make('membros_equipa')->label('Membros da Equipa'),
                            TextInput::make('inicio')
                                ->label('Ano Início')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules(['nullable','integer','min:1900','max:'.$currentYear]),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn() => self::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2),
                ]),

            Section::make('Infraestrutura de Investigação')
                ->description('Registos de infraestrutura de investigação')
                ->collapsed()
                ->schema([
                    Repeater::make('infraestruturasinvestigacaos')
                        ->relationship('infraestruturasinvestigacaos')
                        ->schema([
                            TextInput::make('instituicao')->label('Instituição')->required(),
                            Select::make('tipo_infraestrutura')
                                ->label('Tipo de Infra-Estrutura')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Responsável por criação de laboratório de apoio à investigação científica'=>'Responsável por criação de laboratório de apoio à investigação científica',
                                    'Responsável por reforço de laboratório de apoio à investigação científica'=>'Responsável por reforço de laboratório de apoio à investigação científica',
                                    'Participante na criação de laboratório de apoio à investigação científica'=>'Participante na criação de laboratório de apoio à investigação científica',
                                    'Participante no reforço de laboratório de apoio à investigação científica'=>'Participante no reforço de laboratório de apoio à investigação científica',
                                ]),
                            TextInput::make('laboratorio')->label('Laboratório')->required(),
                            TextInput::make('nome_responsavel')->label('Nome do Responsável')->required(),
                            TextInput::make('registro')->label('Registro'),
                            TextInput::make('ano')
                                ->label('Ano')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules(['nullable','integer','min:1900','max:'.$currentYear]),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn() => self::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2),
                ]),

            Section::make('Reconhecimento na Comunidade Científica')
                ->description('Registos de reconhecimento')
                ->collapsed()
                ->schema([
                    Repeater::make('reconhecimentocomunidadecientificos')
                        ->relationship('reconhecimentocomunidadecientificos')
                        ->schema([
                            Select::make('tipo_reconhecimento')
                                ->label('Tipo de Reconhecimento')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Prémio de sociedade científica'=>'Prémio de sociedade científica',
                                    'Actividade editorial em revista científica internacional indexada de tipo A'=>'Actividade editorial em revista científica internacional indexada de tipo A',
                                    'Actividade editorial em revista científica internacional indexada de tipo B'=>'Actividade editorial em revista científica internacional indexada de tipo B',
                                    'Membro de júri de doutoramento em instituição externa, como arguente'=>'Membro de júri de doutoramento em instituição externa, como arguente',
                                    'Membro de júri de prova pública em instituição externa, como arguente - Professores'=>'Membro de júri de prova pública em instituição externa, como arguente - Professores',
                                    'Prémio recebido por mérito na avaliação de desempenho docente'=>'Prémio recebido por mérito na avaliação de desempenho docente',
                                    'Membro de júri de mestrado em instituição externa, como arguente'=>'Membro de júri de mestrado em instituição externa, como arguente',
                                    'Actividade editorial em conferência internacional de tipo A'=>'Actividade editorial em conferência internacional de tipo A',
                                    'Membro de júri de prova pública em instituição externa, como arguente - Assistentes'=>'Membro de júri de prova pública em instituição externa, como arguente - Assistentes',
                                    'Outros prémios decorrentes da actividade científica'=>'Outros prémios decorrentes da actividade científica',
                                    'Docência como professor visitante em universidade estrangeira'=>'Docência como professor visitante em universidade estrangeira',
                                    'Membro de júri de mestrado na instituição de pertença, como arguente'=>'Membro de júri de mestrado na instituição de pertença, como arguente',
                                    'Actividade editorial em revista científica não indexada'=>'Actividade editorial em revista científica não indexada',
                                    'Actividade editorial em conferência internacional de tipo B'=>'Actividade editorial em conferência internacional de tipo B',
                                    'Participação em comissões científicas de eventos científicos internacionais'=>'Participação em comissões científicas de eventos científicos internacionais',
                                    'Revisor, como árbitro, de artigos publicados em revista científica'=>'Revisor, como árbitro, de artigos publicados em revista científica',
                                    'Actividade editorial em revista científica nacional'=>'Actividade editorial em revista científica nacional',
                                    'Membro de sociedades científicas de admissão selectiva'=>'Membro de sociedades científicas de admissão selectiva',
                                    'Participação em comissões científicas de eventos científicos nacionais'=>'Participação em comissões científicas de eventos científicos nacionais',
                                    'Actividades editoriais em outras publicações científicas'=>'Actividades editoriais em outras publicações científicas',
                                ]),
                            TextInput::make('reconhecimento')->label('Reconhecimento')->required(),
                            TextInput::make('entidade_responsavel')->label('Entidade Responsável'),
                            TextInput::make('classificacao')->label('Classificação'),
                            TextInput::make('tipo_premio')->label('Tipo de Prémio'),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn() => self::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2),
                ]),
        ];
    }
}