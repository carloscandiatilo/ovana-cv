<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use App\Models\Curriculum;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();
        $cards = [];

        if ($user->hasRole('super_admin')) {
            $cards = [
                Card::make('Usuários cadastrados', User::count())
                    ->description('Total no sistema')
                    ->color('success')
                    ->icon('heroicon-o-user-group'),

                Card::make('Permissões cadastradas', Permission::count())
                    ->description('Total no sistema')
                    ->color('primary')
                    ->icon('heroicon-o-key'),

                Card::make('Perfis cadastrados', Role::count())
                    ->description('Total no sistema')
                    ->color('warning')
                    ->icon('heroicon-o-identification'),

                Card::make('Currículos Aprovados', Curriculum::where('status', 'aprovado')->count())
                    ->description('Status aprovado')
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),

                Card::make('Currículos Rejeitados', Curriculum::where('status', 'rejeitado')->count())
                    ->description('Status rejeitado')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),

                Card::make('Currículos Pendentes', Curriculum::where('status', 'pendente')->count())
                    ->description('Status pendente')
                    ->color('warning')
                    ->icon('heroicon-o-clock'),
            ];
        } elseif ($user->hasRole('gestor_cv')) {
            $cards = [
                Card::make('Meus Currículos Aprovados', Curriculum::where('user_id', $user->id)->where('status', 'aprovado')->count())
                    ->description('Status aprovado')
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),

                Card::make('Meus Currículos Rejeitados', Curriculum::where('user_id', $user->id)->where('status', 'rejeitado')->count())
                    ->description('Status rejeitado')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),

                Card::make('Meus Currículos Pendentes', Curriculum::where('user_id', $user->id)->where('status', 'pendente')->count())
                    ->description('Status pendente')
                    ->color('warning')
                    ->icon('heroicon-o-clock'),
            ];
        }

        return $cards;
    }
}
