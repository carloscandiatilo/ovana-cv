<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Rules\AfterOrEqualField; // ← ADICIONADO

class GestaoResource
{
    public static function getFormSchema(): array
    {
        $currentYear = date('Y');
        return [
            Section::make('Cargo Unidade Orgânica')
                ->description('Registos de cargos em unidades orgânicas')
                ->collapsed()
                ->schema([
                    Repeater::make('cargounidadeorganicas')
                        ->relationship('cargounidadeorganicas')
                        ->schema([
                            Select::make('cargo_tipo')
                                ->label('Cargo de Gestão em Órgãos da IES/Unidade Orgânica')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Reitor'=>'Reitor',
                                    'Presidente do Conselho Geral'=>'Presidente do Conselho Geral',
                                    'Vice-Reitor'=>'Vice-Reitor',
                                    'Pró-Reitor'=>'Pró-Reitor',
                                    'Presidente do Senado'=>'Presidente do Senado',
                                    'Membro do Conselho Geral'=>'Membro do Conselho Geral',
                                    'Membro do Senado'=>'Membro do Senado',
                                    'Presidente da Assembleia'=>'Presidente da Assembleia',
                                    'Gestor'=>'Gestor',
                                    'Vice-Gestor'=>'Vice-Gestor',
                                    'Director de Centro de Investigação Científica e Desenvolvimento'=>'Director de Centro de Investigação Científica e Desenvolvimento',
                                    'Vice-Presidente da Assembleia'=>'Vice-Presidente da Assembleia',
                                    'Coordenador da Comissão de Avaliação de Docentes'=>'Coordenador da Comissão de Avaliação de Docentes',
                                    'Membro da Comissão de Avaliação de Docentes'=>'Membro da Comissão de Avaliação de Docentes',
                                    'Membro da Comissão Permanente do Conselho Científico'=>'Membro da Comissão Permanente do Conselho Científico',
                                    'Membro da Comissão Permanente do Conselho Pedagógico'=>'Membro da Comissão Permanente do Conselho Pedagógico',
                                    'Membro da Assembleia'=>'Membro da Assembleia',
                                    'Membro do Conselho de Direcção'=>'Membro do Conselho de Direcção',
                                    'Membro do Conselho Científico'=>'Membro do Conselho Científico',
                                    'Membro do Conselho Pedagógico'=>'Membro do Conselho Pedagógico',
                                ]),
                            TextInput::make('instituicao')->required(),
                            TextInput::make('inicio')
                                ->label('Ano Início')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4),
                            TextInput::make('fim')
                                ->label('Ano Fim')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules([
                                    'nullable',
                                    'integer',
                                    'min:1900',
                                    'max:'.$currentYear,
                                    new AfterOrEqualField('inicio', 'Ano de Início'),
                                ]),
                        ])
                        ->columns(2),
                ]),

            Section::make('Cargo Nível Unidade')
                ->description('Registos de cargos a nível de unidade')
                ->collapsed()
                ->schema([
                    Repeater::make('cargonivelunidades')
                        ->relationship('cargonivelunidades')
                        ->schema([
                            Select::make('cargo_tipo')
                                ->label('Cargo de Gestão em Órgãos da Unidade Orgânica')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Chefe de Departamento'=>'Chefe de Departamento',
                                    'Chefe de Centro de Investigação Científica e Pós-Graduação'=>'Chefe de Centro de Investigação Científica e Pós-Graduação',
                                    'Chefe de Laboratório de Investigação'=>'Chefe de Laboratório de Investigação',
                                    'Coordenador de Programa Doutoral'=>'Coordenador de Programa Doutoral',
                                    'Coordenador de Curso de Mestrado'=>'Coordenador de Curso de Mestrado',
                                    'Coordenador Pedagógico'=>'Coordenador Pedagógico',
                                    'Coordenador Científico'=>'Coordenador Científico',
                                    'Coordenador de Laboratório de Ensino'=>'Coordenador de Laboratório de Ensino',
                                    'Coordenador de Curso de Licenciatura'=>'Coordenador de Curso de Licenciatura',
                                    'Coordenador de Área Académica (Serviços Académicos)'=>'Coordenador de Área Académica (Serviços Académicos)',
                                    'Coordenador de estrutura de gestão interna da qualidade'=>'Coordenador de estrutura de gestão interna da qualidade',
                                    'Coordenador de Ano de curso de licenciatura'=>'Coordenador de Ano de curso de licenciatura',
                                    'Coordenador de Área Científica do Departamento'=>'Coordenador de Área Científica do Departamento',
                                    'Membro da Comissão de Curso'=>'Membro da Comissão de Curso',
                                    'Coordenador de estrutura de gestão da extensão universitária'=>'Coordenador de estrutura de gestão da extensão universitária',
                                ]),
                            TextInput::make('instituicao')->required(),
                            TextInput::make('inicio')
                                ->label('Ano Início')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4),
                            TextInput::make('fim')
                                ->label('Ano Fim')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules([
                                    'nullable',
                                    'integer',
                                    'min:1900',
                                    'max:'.$currentYear,
                                    new AfterOrEqualField('inicio', 'Ano de Início'),
                                ]),
                        ])
                        ->columns(2),
                ]),

            Section::make('Cargo Tarefas Temporárias')
                ->description('Registos de cargos temporários')
                ->collapsed()
                ->schema([
                    Repeater::make('cargotarefastemporarias')
                        ->relationship('cargotarefastemporarias')
                        ->schema([
                            Select::make('cargo_tipo')
                                ->label('Cargos e Tarefas Temporárias realizadas na IES')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Avaliador de programas de I&D internacional'=>'Avaliador de programas de I&D internacional',
                                    'Avaliador de programas de I&D nacional'=>'Avaliador de programas de I&D nacional',
                                    'Coordenador de programa de intercâmbio académico'=>'Coordenador de programa de intercâmbio académico',
                                    'Coordenador de estágio curricular de licenciatura'=>'Coordenador de estágio curricular de licenciatura',
                                    'Membro de Comissão Científica de um curso'=>'Membro de Comissão Científica de um curso',
                                    'Membro de júri de concurso de admissão de pessoal docente'=>'Membro de júri de concurso de admissão de pessoal docente',
                                    'Membro de Comissão Ad-hoc na IES'=>'Membro de Comissão Ad-hoc na IES',
                                    'Participação em programa de avaliação da instituição'=>'Participação em programa de avaliação da instituição',
                                    'Participação em programa de avaliação de desempenho docente'=>'Participação em programa de avaliação de desempenho docente',
                                    'Membro de Comissão Ad-hoc na Unidade Orgânica'=>'Membro de Comissão Ad-hoc na Unidade Orgânica',
                                    'Colaborador na gestão de áreas específicas'=>'Colaborador na gestão de áreas específicas',
                                    'Emissão de parecer técnico sobre projectos ou programas didácticos'=>'Emissão de parecer técnico sobre projectos ou programas didácticos',
                                ]),
                            TextInput::make('entidade')->required(),
                            TextInput::make('inicio')
                                ->label('Ano Início')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4),
                            TextInput::make('fim')
                                ->label('Ano Fim')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules([
                                    'nullable',
                                    'integer',
                                    'min:1900',
                                    'max:'.$currentYear,
                                    new AfterOrEqualField('inicio', 'Ano de Início'),
                                ]),
                        ])
                        ->columns(2),
                ]),

            Section::make('Cargo Órgão Externo')
                ->description('Registos de cargos em órgãos externos')
                ->collapsed()
                ->schema([
                    Repeater::make('cargoorgaosexternos')
                        ->relationship('cargoorgaosexternos')
                        ->schema([
                            Select::make('cargo_tipo')
                                ->label('Cargos em órgãos externos')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Nomeação para Comissão Instaladora de entidade externa'=>'Nomeação para Comissão Instaladora de entidade externa',
                                    'Destacamento temporário para organismo estatal ligado à ciência'=>'Destacamento temporário para organismo estatal ligado à ciência',
                                    'Membro de júri de evento científico ou cultural promovido por entidade externa'=>'Membro de júri de evento científico ou cultural promovido por entidade externa',
                                    'Representante da Unidade Orgânica/IES em órgão de gestão de entidade externa'=>'Representante da Unidade Orgânica/IES em órgão de gestão de entidade externa',
                                    'Membro de Comissão Ad-hoc para realização de uma tarefa em entidade externa'=>'Membro de Comissão Ad-hoc para realização de uma tarefa em entidade externa',
                                    'Membro de Comissão Organizadora de algum evento externo'=>'Membro de Comissão Organizadora de algum evento externo',
                                    'Outros cargos ou funções temporários exercidos na Unidade Orgânica'=>'Outros cargos ou funções temporários exercidos na Unidade Orgânica',
                                ]),
                            TextInput::make('entidade')->required(),
                            TextInput::make('inicio')
                                ->label('Ano Início')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4),
                            TextInput::make('fim')
                                ->label('Ano Fim')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->minLength(4)
                                ->maxLength(4)
                                ->rules([
                                    'nullable',
                                    'integer',
                                    'min:1900',
                                    'max:'.$currentYear,
                                    new AfterOrEqualField('inicio', 'Ano de Início'),
                                ]),
                        ])
                        ->columns(2),
                ]),
        ];
    }
}