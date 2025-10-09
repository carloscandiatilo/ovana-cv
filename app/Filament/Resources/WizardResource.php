<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WizardResource\Pages;
use App\Models\Curriculum;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WizardResource extends Resource
{
    protected static ?string $model = Curriculum::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Currículos';
    protected static ?string $label = 'Currículo';
    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Forms\Components\Wizard\Step::make('Dados Pessoais')
                    ->icon('heroicon-o-user-circle')
                    ->schema(CurriculumResource::getFormSchema()),

                Forms\Components\Wizard\Step::make('Dados de Ensino')
                    ->icon('heroicon-o-academic-cap')
                    ->schema(EnsinoResource::getFormSchema()),

                Forms\Components\Wizard\Step::make('Investigação Científica')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema(\App\Filament\Resources\InvestigacaoResource::getFormSchema()),

                Forms\Components\Wizard\Step::make('Extensão')
                    ->icon('heroicon-o-globe-alt')
                    ->schema(\App\Filament\Resources\ExtensaoResource::getFormSchema()),

                Forms\Components\Wizard\Step::make('Gestão')
                    ->icon('heroicon-o-briefcase')
                    ->schema(\App\Filament\Resources\GestaoResource::getFormSchema()),
            ])
            ->skippable(true)
            ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('pessoal.nome')
                    ->label('Nome')
                    ->getStateUsing(fn (Curriculum $record) => $record->pessoal['nome'] ?? 'N/A'),
                Tables\Columns\TextColumn::make('pessoal.email_pessoal')->label('Email Pessoal'),
                Tables\Columns\TextColumn::make('pessoal.email_profissional')->label('Email Profissional'),
                Tables\Columns\TextColumn::make('pessoal.endereco_pais')->label('País'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aprovado' => 'success',
                        'rejeitado' => 'danger',
                        default     => 'warning',
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make()
                    ->visible(fn (Curriculum $record) =>
                        ! Auth::user()->can('visualizar_qualquer_curriculum') &&
                        $record->user_id === Auth::id()
                    ),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => Auth::user()->can('visualizar_qualquer_curriculum')),

                Tables\Actions\Action::make('validar')
                    ->label('Validar')
                    ->icon('heroicon-o-check-circle')
                    ->modalHeading('Validar Currículo')
                    ->modalDescription('Escolha se deseja aprovar ou Rejeitar este currículo.')
                    ->modalSubmitActionLabel('Confirmar')
                    ->modalWidth('sm')
                    ->form([
                        Forms\Components\Radio::make('status')
                            ->label('Estado')
                            ->options([
                                'aprovado' => 'Aprovar',
                                'rejeitado' => 'Rejeitar',
                            ])
                            ->required(),
                    ])
                    ->action(fn (Curriculum $record, array $data) => $record->update(['status' => $data['status']]))
                    ->visible(fn (Curriculum $record) =>
                        Auth::user()->can('visualizar_qualquer_curriculum') &&
                        in_array($record->status, ['pendente', 'rejeitado'])
                    ),

                Tables\Actions\Action::make('exportar_pdf')
                    ->label('Baixar CV')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function (Curriculum $record) {
                        // Carregar TODOS os relacionamentos de todas as etapas
                        $curriculum = $record->load([
                            // Dados Pessoais já está no modelo principal

                            // Ensino
                            'material_pedagogicos',
                            'orientacao_estudantes',
                            'responsabilidade_orientacoes',
                            'leccionacoes',
                            'infraestrutura_ensinos',

                            // Investigação
                            'producaocientificas',
                            'producaotecnologicas',
                            'projectoinvestigacaos',
                            'infraestruturasinvestigacaos',
                            'reconhecimentocomunidadecientificos',

                            // Extensão
                            'producaonormativas',
                            'prestacaoservicos',
                            'interaccoescomunidade',
                            'mobilizacoesagente',

                            // Gestão
                            'cargounidadeorganicas',
                            'cargonivelunidades',
                            'cargotarefastemporarias',
                            'cargoorgaosexternos',
                        ]);

                        $nome = Str::slug($curriculum->pessoal['nome'] ?? 'curriculo', '_');
                        $filename = "curriculo_{$nome}.pdf";

                        $pdf = Pdf::loadView('curriculums.pdf', compact('curriculum'));

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            $filename,
                            ['Content-Type' => 'application/pdf']
                        );
                    })
                    ->visible(fn (Curriculum $record) =>
                        Auth::user()->can('visualizar_qualquer_curriculum') ||
                        $record->user_id === Auth::id()
                    ),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pendente'  => 'Pendente',
                        'aprovado'  => 'Aprovado',
                        'rejeitado' => 'rejeitado',
                    ]),
            ])
            ->searchable();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (! Auth::user()->can('visualizar_qualquer_curriculum')) {
            $query->where('user_id', Auth::id());
        }
        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListWizards::route('/'),
            'create' => Pages\CreateWizard::route('/create'),
            'edit'   => Pages\EditWizard::route('/{record}/edit'),
            'view'   => Pages\ViewWizard::route('/{record}'),
        ];
    }
}