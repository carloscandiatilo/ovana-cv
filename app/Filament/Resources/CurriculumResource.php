<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurriculumResource\Pages;
use App\Models\Curriculum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurriculumResource extends Resource
{
    protected static ?string $model = Curriculum::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Currículos';
    protected static ?string $label = 'Currículo';

    public static function getNavigationLabel(): string
    {
        return __('Currículos');
    }

    public static function getModelLabel(): string
    {
        return __('Currículo');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Currículos');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (! Auth::user()?->can('visualizar_qualquer_curriculum')) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }

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
            // FOTO & STATUS
            Section::make('Foto & Status')
                ->icon('heroicon-o-camera')
                ->schema([
                    FileUpload::make('avatar')
                        ->label('Foto de Perfil')
                        ->image()
                        ->directory('curriculums/avatars')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png']),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'pendente'  => 'Pendente',
                            'aprovado'  => 'Aprovado',
                            'reprovado' => 'Reprovado',
                        ])
                        ->default('pendente')
                        ->visible(fn () => Auth::user()?->can('editar_curriculum')),
                ])
                ->columns(2)
                ->saveRelationshipsWhenHidden(),

            // DADOS PESSOAIS
            Section::make('Dados Pessoais')
                ->icon('heroicon-o-user')
                ->schema([
                    TextInput::make('pessoal.nome')->label('Nome')->required()->maxLength(255),
                    TextInput::make('pessoal.nome_do_meio')->label('Nome do Meio')->maxLength(255),
                    TextInput::make('pessoal.apelido')->label('Apelido')->maxLength(255),
                    TextInput::make('pessoal.orcid')->label('ORCID')->url()->maxLength(255),
                    TextInput::make('pessoal.instituicao_nome')->label('Instituição')->maxLength(255),
                    TextInput::make('pessoal.endereco_rua_bairro')->label('Rua / Bairro')->maxLength(255),
                    TextInput::make('pessoal.endereco_municipio')->label('Município')->maxLength(255),
                    Select::make('pessoal.endereco_pais')
                        ->label('País')
                        ->searchable()
                        ->options(fn (?string $search = null) => static::getCountryOptions())
                        ->required(),
                    TextInput::make('pessoal.website')->label('Website')->url()->maxLength(255),
                    TextInput::make('pessoal.email_pessoal')->label('E-mail Pessoal')->email()->maxLength(255),
                    TextInput::make('pessoal.email_profissional')->label('E-mail Profissional')->email()->maxLength(255),
                    Select::make('idiomas')
                        ->label('Idiomas')
                        ->multiple()
                        ->relationship('idiomas', 'nome')
                        ->preload()
                        ->searchable(),
                ])
                ->columns(2)
                ->saveRelationshipsWhenHidden(),

            // FORMAÇÕES ACADÊMICAS
            Section::make('Formações Acadêmicas')
                ->icon('heroicon-o-academic-cap')
                ->collapsed()
                ->schema([
                    Repeater::make('formacoes_academicas')
                        ->schema([
                            Select::make('grau_academico')
                                ->label('Grau Acadêmico')
                                ->options([
                                    'Licenciatura'=>'Licenciatura',
                                    'Mestrado'=>'Mestrado',
                                    'Doutorado'=>'Doutorado',
                                    'Pos-Doutorado'=>'Pós-Doutorado',
                                ])
                                ->required(),
                            TextInput::make('instituicao_formacao')->label('Instituição')->maxLength(255),
                            TextInput::make('ano_inicio')
                                ->label('Ano de Início')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive(),
                            TextInput::make('ano_conclusao')
                                ->label('Ano de Conclusão')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    if ($get('ano_inicio') && $state < $get('ano_inicio')) {
                                        $set('ano_conclusao', $get('ano_inicio'));
                                    }
                                }),
                            TextInput::make('titulo_monografia')->label('Título da Monografia')->maxLength(255),
                            TextInput::make('nome_orientador')->label('Orientador')->maxLength(255),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn (?string $search = null) => static::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Formação'),
                ])
                ->saveRelationshipsWhenHidden(),

            // FORMAÇÕES COMPLEMENTARES
            Section::make('Formações Complementares')
                ->icon('heroicon-o-book-open')
                ->collapsed()
                ->schema([
                    Repeater::make('formacoes_complementares')
                        ->schema([
                            TextInput::make('nome_curso')->label('Nome do Curso')->maxLength(255),
                            TextInput::make('instituicao_formacao')->label('Instituição')->maxLength(255),
                            TextInput::make('ano_conclusao')
                                ->label('Ano de Conclusão')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear),
                            TextInput::make('carga_horaria')->label('Carga Horária (h)')->numeric()->minValue(1),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn (?string $search = null) => static::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Formação Complementar'),
                ])
                ->saveRelationshipsWhenHidden(),

            // PRÊMIOS
            Section::make('Prêmios')
                ->icon('heroicon-o-trophy')
                ->collapsed()
                ->schema([
                    Repeater::make('premios')
                        ->schema([
                            TextInput::make('nome_premiacao')->label('Nome da Premiação')->maxLength(255),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                            TextInput::make('ano_atribuicao')
                                ->label('Ano')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn (?string $search = null) => static::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Prémio'),
                ])
                ->saveRelationshipsWhenHidden(),

            // ATUAÇÃO PROFISSIONAL
            Section::make('Atuação Profissional')
                ->icon('heroicon-o-briefcase')
                ->collapsed()
                ->schema([
                    Repeater::make('actuacoes_profissionais')
                        ->schema([
                            TextInput::make('instituicao')->label('Instituição')->required()->maxLength(255),
                            Select::make('tipo_vinculo')
                                ->label('Tipo de Vínculo')
                                ->options([
                                    'Efectivo'=>'Efetivo',
                                    'Convidado'=>'Convidado',
                                    'Visitante'=>'Visitante',
                                    'Colaborador'=>'Colaborador',
                                ])
                                ->required(),
                            TextInput::make('funcao')->label('Função')->maxLength(255),
                            TextInput::make('ano_inicio')
                                ->label('Ano de Início')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive(),
                            TextInput::make('ano_fim')
                                ->label('Ano de Fim')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    if ($get('ano_inicio') && $state < $get('ano_inicio')) {
                                        $set('ano_fim', $get('ano_inicio'));
                                    }
                                }),
                            Select::make('pais')
                                ->label('País')
                                ->searchable()
                                ->options(fn (?string $search = null) => static::getCountryOptions())
                                ->required(),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Atuação'),
                ])
                ->saveRelationshipsWhenHidden(),

            // DOCÊNCIA
            Section::make('Docência')
                ->icon('heroicon-o-user')
                ->collapsed()
                ->schema([
                    Repeater::make('actuacoes_docencias')
                        ->schema([
                            Select::make('pais')->label('País')->searchable()->options(fn (?string $s = null) => static::getCountryOptions())->required(),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                            TextInput::make('disciplina')->label('Disciplina')->maxLength(255),
                            TextInput::make('carga_horaria')->label('Carga Horária (h)')->numeric()->minValue(1),
                            TextInput::make('ano')
                                ->label('Ano')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue($currentYear),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Docência'),
                ])
                ->saveRelationshipsWhenHidden(),

            // INVESTIGAÇÃO CIENTÍFICA
            Section::make('Investigação Científica')
                ->icon('heroicon-o-magnifying-glass')
                ->collapsed()
                ->schema([
                    Repeater::make('investigacoes_cientificas')
                        ->schema([
                            Select::make('pais')->label('País')->searchable()->options(fn (?string $s = null) => static::getCountryOptions())->required(),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                            TextInput::make('linha_investigacao')->label('Linha de Investigação')->maxLength(255),
                            TextInput::make('titulo_projeto')->label('Título do Projeto')->maxLength(255),
                            TextInput::make('numero_membros')->label('Nº de Membros')->numeric()->minValue(0)->maxValue(50),
                            Repeater::make('membros_equipa')
                                ->label('Membros da Equipa')
                                ->schema([
                                    TextInput::make('nome')->label('Nome do Membro')->required()->maxLength(255),
                                ])
                                ->columns(1)
                                ->maxItems(50),
                            TextInput::make('financiador')->label('Financiador')->maxLength(255),
                            TextInput::make('ano_inicio')
                                ->label('Ano de Início')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive(),
                            TextInput::make('ano_fim')
                                ->label('Ano de Fim')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    if ($get('ano_inicio') && $state < $get('ano_inicio')) {
                                        $set('ano_fim', $get('ano_inicio'));
                                    }
                                }),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Investigação'),
                ])
                ->saveRelationshipsWhenHidden(),

            // EXTENSÃO UNIVERSITÁRIA
            Section::make('Extensão Universitária')
                ->icon('heroicon-o-building-library')
                ->collapsed()
                ->schema([
                    Repeater::make('extensoes_universitarias')
                        ->schema([
                            Select::make('pais')->label('País')->searchable()->options(fn (?string $s = null) => static::getCountryOptions())->required(),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                            TextInput::make('projeto_extensao')->label('Projeto de Extensão')->maxLength(255),
                            TextInput::make('membros_equipa')->label('Membros da Equipa')->maxLength(255),
                            TextInput::make('ano_inicio')->label('Ano de Início')->numeric()->minValue(1900)->maxValue($currentYear)->reactive(),
                            TextInput::make('ano_fim')
                                ->label('Ano de Fim')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    if ($get('ano_inicio') && $state < $get('ano_inicio')) {
                                        $set('ano_fim', $get('ano_inicio'));
                                    }
                                }),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Extensão'),
                ])
                ->saveRelationshipsWhenHidden(),

            // CAPTAÇÃO DE FINANCIAMENTO
            Section::make('Captação de Financiamento')
                ->icon('heroicon-o-banknotes')
                ->collapsed()
                ->schema([
                    Repeater::make('captacoes_financiamentos')
                        ->schema([
                            Select::make('pais')->label('País')->searchable()->options(fn (?string $s = null) => static::getCountryOptions())->required(),
                            TextInput::make('instituicao')->label('Instituição')->maxLength(255),
                            TextInput::make('nome_projeto')->label('Nome do Projeto')->maxLength(255),
                            TextInput::make('natureza_projeto')->label('Natureza do Projeto')->maxLength(255),
                            TextInput::make('codigo_registro')->label('Código de Registro')->maxLength(255),
                            TextInput::make('ano_inicio')->label('Ano de Início')->numeric()->minValue(1900)->maxValue($currentYear)->reactive(),
                            TextInput::make('ano_fim')
                                ->label('Ano de Fim')
                                ->numeric()
                                ->maxLength(4)
                                ->minValue(1900)
                                ->maxValue($currentYear)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    if ($get('ano_inicio') && $state < $get('ano_inicio')) {
                                        $set('ano_fim', $get('ano_inicio'));
                                    }
                                }),
                            TextInput::make('membros_equipa')->label('Membros da Equipa')->maxLength(255),
                            TextInput::make('valor_arrecadado')->label('Valor Arrecadado')->numeric()->minValue(0),
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('Adicionar Captação'),
                ])
                ->saveRelationshipsWhenHidden(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')->label('Foto')->circular()->toggleable(false),
                TextColumn::make('status')->label('Status')->badge()->color(fn(?string $state)=>match($state){'aprovado'=>'success','reprovado'=>'danger',default=>'warning'}),
                TextColumn::make('pessoal.nome')->label('Nome')->getStateUsing(fn(Curriculum $r)=>$r->pessoal['nome']??'N/A')->searchable()->sortable(),
                TextColumn::make('pessoal.email_pessoal')->label('Email Pessoal')->getStateUsing(fn(Curriculum $r)=>$r->pessoal['email_pessoal']??null)->wrap(),
                TextColumn::make('pessoal.email_profissional')->label('Email Profissional')->getStateUsing(fn(Curriculum $r)=>$r->pessoal['email_profissional']??null)->wrap(),
                TextColumn::make('pessoal.endereco_pais')->label('País')->wrap(),
                TextColumn::make('pessoal.orcid')->label('Orcid')->getStateUsing(fn(Curriculum $r)=>$r->pessoal['orcid']??null)->wrap(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pendente'=>'Pendente',
                    'aprovado'=>'Aprovado',
                    'reprovado'=>'Reprovado',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'=>Pages\ListCurricula::route('/'),
            'create'=>Pages\CreateCurriculum::route('/create'),
            'edit'=>Pages\EditCurriculum::route('/{record}/edit'),
            'view'=>Pages\ViewCurriculum::route('/{record}'),
        ];
    }
}
