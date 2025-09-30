<?php

namespace App\Filament\Resources\GestaoResource\Pages;

use App\Filament\Resources\GestaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGestao extends EditRecord
{
    protected static string $resource = GestaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
