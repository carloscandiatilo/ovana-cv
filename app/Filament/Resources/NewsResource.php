<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\Base\Resource as BaseResource;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class NewsResource extends BaseResource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Portal';

    public static function getNavigationLabel(): string
    {
        return __('Notícias');
    }

    public static function getModelLabel(): string
    {
        return __('Notícia');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Notícias');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalhes da Notícia')
                    ->description('Preencha os detalhes da notícia e associe uma categoria.')
                    ->icon('heroicon-o-newspaper')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->columnSpanFull()
                            ->autofocus(),

                        Select::make('category_id')
                            ->label('Categoria')
                            ->relationship('category', 'name')
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nome da Categoria')
                                    ->required(),
                            ])
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('user_id')
                            ->default(fn () => auth()->id()),

                        Textarea::make('content')
                            ->label('Conteúdo')
                            ->required()
                            ->columnSpanFull()
                            ->rows(10),

                        FileUpload::make('media')
                            ->label('Mídia (Foto ou Vídeo)')
                            ->acceptedFileTypes(['image/*', 'video/mp4'])
                            ->columnSpanFull(),

                        Toggle::make('published')
                            ->label('Publicado?')
                            ->default(false)
                            ->inline()
                            ->columnSpanFull(),

                        Toggle::make('isdestaque')
                          ->label('Destaque?')
                          ->default(false)
                          ->inline()
                          ->columnSpanFull(),
                    ])
                    
                    ->compact()
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Título')->searchable()->sortable(),
                TextColumn::make('user.name')->label('Autor')->sortable(),
                TextColumn::make('category.name')->label('Categoria')->sortable(),
                Tables\Columns\IconColumn::make('media')
                ->label('Mídia')
                ->boolean() 
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),
                Tables\Columns\IconColumn::make('published')
                    ->label('Publicado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Ver'),
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Excluir'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Excluir selecionados'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
