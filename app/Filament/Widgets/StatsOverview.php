<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use App\Models\Curriculum;
use Spatie\Permission\Models\Role;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Usuários cadastrados', User::count())
                ->description('Total no sistema')
                ->color('success')
                ->icon('heroicon-o-user-group'),

            Card::make('Currículos cadastrados', Curriculum::count())
                ->description('Total no sistema')
                ->color('primary')
                ->icon('heroicon-o-document-text'),

            Card::make('Perfis cadastrados', Role::count())
                ->description('Total no sistema')
                ->color('warning')
                ->icon('heroicon-o-identification'),
        ];
    }
}
