<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\Base\Resource; 
use Spatie\Permission\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class PermissionResource extends Resource // 👈
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = 'Permissões';

    public static function getNavigationLabel(): string
    {
        return __('Permissões');
    }

    public static function getModelLabel(): string
    {
        return __('Permissão');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Permissões');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalhes da Permissão')
                    ->description('Defina o nome único da permissão. O guard é definido automaticamente como "web".')
                    ->icon('heroicon-o-key')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome da Permissão')
                            ->placeholder('Ex: criar_usuários, visualizar_relatorios...')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->autofocus()
                            ->columnSpanFull(),

                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->columnSpanFull()
                    ])
                    ->compact(),
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
                    ->modalHeading('Editar Permissão')
                    ->modalSubmitActionLabel('Salvar'),

                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Excluir Permissão')
                    ->modalDescription('Tem certeza de que deseja excluir esta permissão? Esta ação não pode ser desfeita e pode afetar roles e usuários associados.')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
        ];
    }
}