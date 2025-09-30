<?php

namespace App\Filament\Resources\InvestigacaoResource\Pages;

use App\Filament\Resources\InvestigacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvestigacao extends EditRecord
{
    protected static string $resource = InvestigacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
