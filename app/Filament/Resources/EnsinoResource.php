<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnsinoResource\Pages;
use App\Filament\Resources\Base\Resource;
use App\Models\Ensino;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class EnsinoResource extends Resource
{
    protected static ?string $model = Ensino::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Currículos';

    /**
     * Form (standalone) — inclui hidden curriculum_id e usa schema().
     */
    public static function form(Form $form): Form
    {
        return $form->schema(array_merge(
            [
                Hidden::make('curriculum_id')
                    ->default(fn () => request()->query('curriculum_id'))
                    ->required(),
            ],
            static::schema()
        ))->columns(1);
    }

    /**
     * Alias compatível (se algum código chamar getFormSchema()).
     */
    public static function getFormSchema(): array
    {
        return static::schema();
    }

    /**
     * Schema reutilizável — usado também pelo Wizard (Repeater->schema())
     */
    public static function schema(): array
    {
        $currentYear = date('Y');

        return [
            TextInput::make('disciplina')
                ->label('Disciplina')
                ->required()
                ->maxLength(255),

            TextInput::make('instituicao')
                ->label('Instituição')
                ->maxLength(255),

            TextInput::make('ano')
                ->label('Ano')
                ->numeric()
                ->minValue(1900)
                ->maxValue($currentYear),
        ];
    }

    /**
     * Table columns
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('ID')->sortable(),
            TextColumn::make('curriculum.pessoal.nome')->label('Currículo')->wrap(),
            TextColumn::make('disciplina')->label('Disciplina')->wrap(),
            TextColumn::make('instituicao')->label('Instituição')->wrap(),
            TextColumn::make('ano')->label('Ano')->sortable(),
        ]);
    }

    /**
     * Pages (List/Create/Edit)
     */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEnsinos::route('/'),
            'create' => Pages\CreateEnsino::route('/create'),
            'edit'   => Pages\EditEnsino::route('/{record}/edit'),
        ];
    }
}
