<?php

namespace App\Filament\Resources\EnsinoResource\Pages;

use App\Filament\Resources\EnsinoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnsinos extends ListRecords
{
    protected static string $resource = EnsinoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
