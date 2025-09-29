<?php

namespace App\Filament\Resources\EnsinoResource\Pages;

use App\Filament\Resources\EnsinoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnsino extends EditRecord
{
    protected static string $resource = EnsinoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
