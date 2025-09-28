<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Permissões';

    protected static ?string $recordTitleAttribute = 'name';

        public static function getNavigationLabel(): string
    {
        return __('Usuários');
    }

    public static function getModelLabel(): string
    {
        return __('Usuário');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Usuários');
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Informações do Usuário')
                ->icon('heroicon-o-user')
                ->description('Dados básicos do usuário.')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255)
                        ->autofocus(),

                    TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                ])
                ->columns(2),

            Section::make('Senha')
                ->icon('heroicon-o-lock-closed')
                ->description('Preencha os campos abaixo para definir ou alterar a senha.')
                ->schema([
                    TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->revealable()
                        ->minLength(8)
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->helperText(fn (string $operation) => $operation === 'create'
                            ? 'Mínimo de 8 caracteres.'
                            : 'Deixe em branco para manter a senha atual.'),

                    TextInput::make('passwordConfirmation')
                        ->label('Confirmar Senha')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->same('password')
                        ->dehydrated(false)
                        ->helperText(fn (string $operation) => $operation === 'create'
                            ? 'Confirme a senha digitada acima.'
                            : 'Confirme apenas se estiver alterando a senha.'),
                ])
                ->columns(2) // 👈 Lado a lado!
                ->compact(),

            Section::make('Acesso e Permissões')
                ->icon('heroicon-o-shield-check')
                ->description('Atribua roles para definir as permissões do usuário.')
                ->schema([
                    Select::make('roles')
                        ->label('Roles')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload()
                        ->searchable()
                        ->placeholder('Selecione uma ou mais roles...')
                        ->helperText('As roles determinam o que o usuário pode fazer no sistema.'),
                ])
                ->compact(),
        ]);
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->color('primary')
                    ->separator(', ')
                    ->limitList(3)
                    ->tooltip(fn ($record) => $record->roles->pluck('name')->join(', ')),

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
                    ->modalHeading('Editar Usuário')
                    ->modalSubmitActionLabel('Salvar'),

                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Excluir Usuário')
                    ->modalDescription('Tem certeza? Todos os dados serão perdidos.')
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with('roles');
    }

    public static function mutateFormDataBeforeSave($data)
    {
        if (filled($data['password'] ?? null)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        return $data;
    }
}