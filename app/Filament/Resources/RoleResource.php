<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Spatie\Permission\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Permissões';

        public static function getNavigationLabel(): string
    {
        return __('Perfis');
    }

    public static function getModelLabel(): string
    {
        return __('Perfil');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Perfis');
    } 
    

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Detalhes da Role')
                ->description('Defina o nome e as permissões associadas a esta role.')
                ->icon('heroicon-o-shield-check')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome da Role')
                        ->placeholder('Ex: Administrador, Editor, Leitor...')
                        ->required()
                        ->maxLength(100)
                        ->unique(ignoreRecord: true)
                        ->autofocus()
                        ->columnSpanFull(),

                    Forms\Components\Grid::make()
                        ->schema([
                            Select::make('permissions')
                                ->label('Permissões')
                                ->multiple()
                                ->relationship('permissions', 'name')
                                ->preload()
                                ->searchable(['name'])
                                ->placeholder('Selecione as permissões...')
                                ->columnSpanFull()
                                ->helperText('As permissões definem o que esta role pode ou não fazer no sistema.'),
                        ])
                        ->columns(1),
                ])
                ->compact()
        ])
        ->columns(1); 
}

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            TextColumn::make('permissions.name')
                ->label('Permissões')
                ->badge()
                ->color('success')
                ->separator(', ')
                ->limitList(3)
                ->tooltip(fn ($record) => $record->permissions->pluck('name')->join(', ')),

            TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),

            TextColumn::make('updated_at')
                ->label('Atualizado em')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()
                ->modalHeading('Editar Role')
                ->modalSubmitActionLabel('Salvar'),

            Tables\Actions\DeleteAction::make()
                ->modalHeading('Excluir Role')
                ->modalDescription('Tem certeza de que deseja excluir esta role? Esta ação não pode ser desfeita.')
                ->requiresConfirmation(),
        ])
        ->headerActions([
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('created_at', 'desc');
}

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('permissions');
    }

    // ✅ Só mantém a página de listagem
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            // Remova 'create' e 'edit' — usamos modais!
        ];
    }
}