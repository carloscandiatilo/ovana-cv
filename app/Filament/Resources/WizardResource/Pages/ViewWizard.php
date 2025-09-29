<?php

namespace App\Filament\Resources\WizardResource\Pages;

use App\Filament\Resources\WizardResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Models\Curriculum;
use Filament\Forms;

class ViewWizard extends ViewRecord
{
    protected static string $resource = WizardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn (Curriculum $record) =>
                    in_array($record->status, ['pendente', 'reprovado'])
                ),

            Actions\DeleteAction::make()
                ->visible(fn () => Auth::user()->can('visualizar_qualquer_curriculum')),

            Actions\Action::make('validar')
                ->label('Validar')
                ->icon('heroicon-o-check-circle')
                ->color('primary')
                ->modalHeading('Validar Currículo')
                ->modalDescription('Escolha se deseja aprovar ou reprovar este currículo.')
                ->modalSubmitActionLabel('Confirmar')
                ->modalWidth('sm')
                ->form([
                    Forms\Components\Radio::make('status')
                        ->label('Estado')
                        ->options([
                            'aprovado' => 'Aprovar',
                            'reprovado' => 'Reprovar',
                        ])
                        ->required(),
                ])
                ->action(function (Curriculum $record, array $data) {
                    $record->update(['status' => $data['status']]);
                })
                ->visible(fn (Curriculum $record) =>
                    in_array($record->status, ['pendente', 'reprovado']) &&
                    Auth::user()->can('validar_curriculum')
                ),
        ];
    }
}
