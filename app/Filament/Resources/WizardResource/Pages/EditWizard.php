<?php

namespace App\Filament\Resources\WizardResource\Pages;

use App\Filament\Resources\WizardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditWizard extends EditRecord
{
    protected static string $resource = WizardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => Auth::user()->can('visualizar_qualquer_curriculum')),
        ];
    }
}
