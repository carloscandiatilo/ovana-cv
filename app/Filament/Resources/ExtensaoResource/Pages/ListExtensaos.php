<?php

namespace App\Filament\Resources\ExtensaoResource\Pages;

use App\Filament\Resources\ExtensaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtensaos extends ListRecords
{
    protected static string $resource = ExtensaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
