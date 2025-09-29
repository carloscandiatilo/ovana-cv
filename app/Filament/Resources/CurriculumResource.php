<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurriculumResource\Pages;
use App\Filament\Resources\Base\Resource;
use App\Models\Curriculum;
use App\Models\Idioma;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class CurriculumResource extends Resource
{
    protected static ?string $model = Curriculum::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Currículos';

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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (! Auth::user()->can('visualizar_qualquer_curriculum')) {
            $query->where('user_id', Auth::id());
        }
        return $query;
    }

    public static function form(Form $form): Form
    {
        $currentYear = date('Y');

        $paises = [
            'Angola',
            'Brazil',
        ];

        $provinciasAngola = [
            'Luanda',
            'Bengo',
        ];

        return $form
            ->schema([
                // Foto de Perfil
                Section::make('Foto de Perfil')
                    ->icon('heroicon-o-camera')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Foto de Perfil')
                            ->image()
                            ->directory('curriculums/avatars')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png']),
                    ])
                    ->columns(1),

                // Status (só admin)
                Section::make('Status')
                    ->visible(fn () => Auth::user()->can('editar_curriculum'))
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pendente' => 'Pendente',
                                'aprovado' => 'Aprovado',
                                'reprovado' => 'Reprovado',
                            ])
                            ->required()
                            ->default('pendente'),
                    ]),

                // Dados Pessoais
                Section::make('Dados Pessoais')
                    ->icon('heroicon-o-user')
                    ->collapsible()
                    ->schema([
                        TextInput::make('pessoal.nome')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('pessoal.nome_do_meio')
                            ->label('Nome do Meio')
                            ->maxLength(255),

                        TextInput::make('pessoal.apelido')
                            ->label('Apelido')
                            ->maxLength(255),

                        TextInput::make('pessoal.orcid')
                            ->label('ORCID')
                            ->url(),

                        TextInput::make('pessoal.instituicao_nome')
                            ->label('Instituição')
                            ->maxLength(255),

                        TextInput::make('pessoal.endereco_rua_bairro')
                            ->label('Rua/Bairro')
                            ->maxLength(255),

                        TextInput::make('pessoal.endereco_municipio')
                            ->label('Município')
                            ->maxLength(255),

                        Select::make('pessoal.endereco_pais')
                            ->label('País')
                            ->options(array_combine($paises, $paises))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('pessoal.endereco_provincia', null)),

                        Select::make('pessoal.endereco_provincia')
                            ->label('Província')
                            ->options(fn (Forms\Get $get) => $get('pessoal.endereco_pais') === 'Angola' ? array_combine($provinciasAngola, $provinciasAngola) : [])
                            ->visible(fn (Forms\Get $get) => $get('pessoal.endereco_pais') === 'Angola')
                            ->searchable(),

                        TextInput::make('pessoal.website')
                            ->label('Website')
                            ->url(),

                        TextInput::make('pessoal.email_pessoal')
                            ->label('E-mail Pessoal')
                            ->email(),

                        TextInput::make('pessoal.email_profissional')
                            ->label('E-mail Profissional')
                            ->email(),

                        Select::make('idiomas')
                            ->label('Idiomas')
                            ->multiple()
                            ->relationship('idiomas', 'nome')
                            ->preload()
                            ->searchable(),
                    ])
                    ->columns(2),

                // Formações Acadêmicas
                Section::make('Formações Acadêmicas')
                    ->icon('heroicon-o-academic-cap')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('formacoes_academicas')
                            ->schema([
                                Select::make('grau_academico')
                                    ->label('Grau Acadêmico')
                                    ->options([
                                        'Licenciatura' => 'Licenciatura',
                                        'Mestrado' => 'Mestrado',
                                        'Doutorado' => 'Doutorado',
                                        'Pos-Doutorado' => 'Pós-Doutorado',
                                    ])
                                    ->required(),

                                TextInput::make('ano_inicio')
                                    ->label('Ano de Início')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('ano_conclusao')
                                    ->label('Ano de Conclusão')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('instituicao_formacao')
                                    ->label('Instituição')
                                    ->maxLength(255),

                                TextInput::make('titulo_monografia')
                                    ->label('Título da Monografia')
                                    ->maxLength(255),

                                TextInput::make('nome_orientador')
                                    ->label('Orientador')
                                    ->maxLength(255),

                                Select::make('pais')
                                    ->label('País')
                                    ->options(array_combine($paises, $paises))
                                    ->searchable(),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),

                // Formações Complementares
                Section::make('Formações Complementares')
                    ->icon('heroicon-o-book-open')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('formacoes_complementares')
                            ->schema([
                                Select::make('nivel')
                                    ->label('Nível')
                                    ->options([
                                        'Curso de Curta Duração' => 'Curso de Curta Duração',
                                        'Especialização' => 'Especialização',
                                        'Pos-Doutorado' => 'Pós-Doutorado',
                                    ])
                                    ->required(),

                                TextInput::make('nome_curso')
                                    ->label('Nome do Curso')
                                    ->maxLength(255),

                                TextInput::make('ano_conclusao')
                                    ->label('Ano de Conclusão')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('carga_horaria')
                                    ->label('Carga Horária (h)')
                                    ->numeric()
                                    ->minValue(1),

                                TextInput::make('instituicao_formacao')
                                    ->label('Instituição')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),

                // Prêmios
                Section::make('Prêmios')
                    ->icon('heroicon-o-trophy')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('premios')
                            ->schema([
                                TextInput::make('nome_premiacao')
                                    ->label('Nome da Premiação')
                                    ->maxLength(255),

                                TextInput::make('ano_atribuicao')
                                    ->label('Ano')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('instituicao')
                                    ->label('Instituição')
                                    ->maxLength(255),

                                Select::make('pais')
                                    ->label('País')
                                    ->options(array_combine($paises, $paises))
                                    ->searchable(),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),

                // Atuação Profissional
                Section::make('Atuação Profissional')
                    ->icon('heroicon-o-briefcase')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('actuacoes_profissionais')
                            ->schema([
                                TextInput::make('instituicao')
                                    ->label('Instituição')
                                    ->maxLength(255)
                                    ->required(),

                                Select::make('tipo_vinculo')
                                    ->label('Tipo de Vínculo')
                                    ->options([
                                        'Efectivo' => 'Efetivo',
                                        'Convidado' => 'Convidado',
                                        'Visitante' => 'Visitante',
                                        'Colaborador' => 'Colaborador',
                                    ])
                                    ->required(),

                                TextInput::make('funcao')
                                    ->label('Função')
                                    ->maxLength(255),

                                TextInput::make('ano_inicio')
                                    ->label('Ano de Início')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('ano_fim')
                                    ->label('Ano de Fim')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),

                // Docência
                Section::make('Docência')
                    ->icon('heroicon-o-user')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('actuacoes_docencias')
                            ->schema([
                                Select::make('pais')
                                    ->label('País')
                                    ->options(array_combine($paises, $paises))
                                    ->searchable(),

                                TextInput::make('instituicao')
                                    ->label('Instituição')
                                    ->maxLength(255),

                                TextInput::make('disciplina')
                                    ->label('Disciplina')
                                    ->maxLength(255),

                                TextInput::make('carga_horaria')
                                    ->label('Carga Horária (h)')
                                    ->numeric()
                                    ->minValue(1),

                                TextInput::make('ano')
                                    ->label('Ano')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),

                // Investigação Científica
                Section::make('Investigação Científica')
                    ->icon('heroicon-o-magnifying-glass')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('investigacoes_cientificas')
                            ->schema([
                                Select::make('pais')
                                    ->label('País')
                                    ->options(array_combine($paises, $paises))
                                    ->searchable(),

                                TextInput::make('instituicao')
                                    ->label('Instituição')
                                    ->maxLength(255),

                                TextInput::make('linha_investigacao')
                                    ->label('Linha de Investigação')
                                    ->maxLength(255),

                                TextInput::make('titulo_projeto')
                                    ->label('Título do Projeto')
                                    ->maxLength(255),

                                TextInput::make('numero_membros')
                                    ->label('Nº de Membros')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(5)
                                    ->integer()
                                    ->live(onBlur: true),

                                Repeater::make('membros_equipa')
                                    ->label('Membros da Equipa')
                                    ->schema([
                                        TextInput::make('nome')
                                            ->label('Nome do Membro')
                                            ->required(),
                                    ])
                                    ->visible(fn (Forms\Get $get) => ($get('../../numero_membros') ?? 0) > 0)
                                    ->maxItems(fn (Forms\Get $get) => $get('../../numero_membros') ?? 0)
                                    ->columns(1)
                                    ->columnSpanFull(),

                                TextInput::make('financiador')
                                    ->label('Financiador')
                                    ->maxLength(255),

                                TextInput::make('ano_inicio')
                                    ->label('Ano de Início')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('ano_fim')
                                    ->label('Ano de Fim')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),

                // Extensão Universitária
                Section::make('Extensão Universitária')
                    ->icon('heroicon-o-building-library')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('extensoes_universitarias')
                            ->schema([
                                Select::make('pais')
                                    ->label('País')
                                    ->options(array_combine($paises, $paises))
                                    ->searchable(),

                                TextInput::make('instituicao')
                                    ->label('Instituição')
                                    ->maxLength(255),

                                TextInput::make('projeto_extensao')
                                    ->label('Projeto de Extensão')
                                    ->maxLength(255),

                                TextInput::make('membros_equipa')
                                    ->label('Membros da Equipa')
                                    ->maxLength(255),

                                TextInput::make('ano_inicio')
                                    ->label('Ano de Início')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('ano_fim')
                                    ->label('Ano de Fim')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),

                // Captação de Financiamento
                Section::make('Captação de Financiamento')
                    ->icon('heroicon-o-banknotes')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('captacoes_financiamentos')
                            ->schema([
                                Select::make('pais')
                                    ->label('País')
                                    ->options(array_combine($paises, $paises))
                                    ->searchable(),

                                TextInput::make('instituicao')
                                    ->label('Instituição')
                                    ->maxLength(255),

                                TextInput::make('nome_projeto')
                                    ->label('Nome do Projeto')
                                    ->maxLength(255),

                                TextInput::make('natureza_projeto')
                                    ->label('Natureza do Projeto')
                                    ->maxLength(255),

                                TextInput::make('codigo_registro')
                                    ->label('Código de Registro')
                                    ->maxLength(255),

                                TextInput::make('ano_inicio')
                                    ->label('Ano de Início')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('ano_fim')
                                    ->label('Ano de Fim')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue($currentYear),

                                TextInput::make('membros_equipa')
                                    ->label('Membros da Equipa')
                                    ->maxLength(255),

                                TextInput::make('valor_arrecadado')
                                    ->label('Valor Arrecadado')
                                    ->numeric()
                                    ->minValue(0),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
                    ]),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('pessoal.nome')
                    ->label('Nome')
                    ->getStateUsing(fn (Curriculum $record) => $record->pessoal['nome'] ?? 'N/A'),

                     TextColumn::make('pessoal.email_pessoal')
                    ->label('Email Pessoal'),

                     TextColumn::make('pessoal.email_profissional')
                    ->label('Email Profissional'),

                    

                TextColumn::make('pessoal.endereco_pais')
                    ->label('País'),

                    TextColumn::make('pessoal.orcid')
                    ->label('Orcid'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aprovado' => 'success',
                        'reprovado' => 'danger',
                        default => 'warning',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'aprovado' => 'Aprovado',
                        'reprovado' => 'Reprovado',
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
            'index' => Pages\ListCurricula::route('/'),
            'create' => Pages\CreateCurriculum::route('/create'),
            'edit' => Pages\EditCurriculum::route('/{record}/edit'),
        ];
    }

}