<?php

namespace App\Filament\Resources\WizardResource\Pages;

use App\Filament\Resources\WizardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWizards extends ListRecords
{
    protected static string $resource = WizardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
