<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WizardResource\Pages;
use App\Models\Curriculum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WizardResource extends Resource
{
    protected static ?string $model = Curriculum::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Currículos';
    protected static ?string $label = 'Currículo';
    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                // Passo 1: Dados Pessoais
                Forms\Components\Wizard\Step::make('Dados Pessoais')
                    ->icon('heroicon-o-user-circle')
                    ->schema(CurriculumResource::getFormSchema()),

                // Passo 2: Dados de Ensino
                Forms\Components\Wizard\Step::make('Dados de Ensino')
                    ->icon('heroicon-o-academic-cap')
                    ->schema(EnsinoResource::getFormSchema()),

                // Passo 3: Investigação
                Forms\Components\Wizard\Step::make('Investigação Científica')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema(\App\Filament\Resources\InvestigacaoResource::getFormSchema()),

                Forms\Components\Wizard\Step::make('Extensão')
                    ->icon('heroicon-o-globe-alt')
                    ->schema(\App\Filament\Resources\ExtensaoResource::getFormSchema()),

                Forms\Components\Wizard\Step::make('Gestão')
                    ->icon('heroicon-o-briefcase')
                    ->schema(\App\Filament\Resources\GestaoResource::getFormSchema()),


            ])
            ->skippable(true)
            ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('pessoal.nome')
                    ->label('Nome')
                    ->getStateUsing(fn (Curriculum $record) => $record->pessoal['nome'] ?? 'N/A'),
                Tables\Columns\TextColumn::make('pessoal.email_pessoal')->label('Email Pessoal'),
                Tables\Columns\TextColumn::make('pessoal.email_profissional')->label('Email Profissional'),
                Tables\Columns\TextColumn::make('pessoal.endereco_pais')->label('País'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aprovado' => 'success',
                        'reprovado' => 'danger',
                        default     => 'warning',
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (Curriculum $record) =>
                        ! Auth::user()->can('visualizar_qualquer_curriculum') &&
                        $record->user_id === Auth::id()
                    ),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => Auth::user()->can('visualizar_qualquer_curriculum')),
                Tables\Actions\Action::make('validar')
                    ->label('Validar')
                    ->icon('heroicon-o-check-circle')
                    ->modalHeading('Validar Currículo')
                    ->modalDescription('Escolha se deseja aprovar ou reprovar este currículo.')
                    ->modalSubmitActionLabel('Confirmar')
                    ->modalWidth('sm')
                    ->form([
                        Forms\Components\Radio::make('status')
                            ->label('Estado')
                            ->options([
                                'aprovado' => 'Aprovar',
                                'reprovado' => 'Reprovar',
                            ])
                            ->required(),
                    ])
                    ->action(fn (Curriculum $record, array $data) => $record->update(['status' => $data['status']]))
                    ->visible(fn (Curriculum $record) =>
                        Auth::user()->can('visualizar_qualquer_curriculum') &&
                        in_array($record->status, ['pendente', 'reprovado'])
                    ),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pendente'  => 'Pendente',
                        'aprovado'  => 'Aprovado',
                        'reprovado' => 'Reprovado',
                    ]),
            ])
            ->searchable();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (! Auth::user()->can('visualizar_qualquer_curriculum')) {
            $query->where('user_id', Auth::id());
        }
        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListWizards::route('/'),
            'create' => Pages\CreateWizard::route('/create'),
            'edit'   => Pages\EditWizard::route('/{record}/edit'),
            'view'   => Pages\ViewWizard::route('/{record}'),
        ];
    }
}
