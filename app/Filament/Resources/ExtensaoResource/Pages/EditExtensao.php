<?php

namespace App\Filament\Resources\ExtensaoResource\Pages;

use App\Filament\Resources\ExtensaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtensao extends EditRecord
{
    protected static string $resource = ExtensaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
