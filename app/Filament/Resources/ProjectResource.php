<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Projet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Détails du projet')
                    ->schema([
                        Forms\Components\TextInput::make('titre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                        Forms\Components\Select::make('statut')
                            ->options([
                                'ouvert' => 'Ouvert',
                                'en_cours' => 'En cours',
                                'fermé' => 'Fermé',
                            ])
                            ->default('ouvert')
                            ->required(),
                        Forms\Components\DatePicker::make('date_de_début')
                            ->nullable(),
                        Forms\Components\DatePicker::make('date_de_fin')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titre')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('statut')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('date_de_début')->date()->sortable(),
                Tables\Columns\TextColumn::make('date_de_fin')->date()->sortable(),
                Tables\Columns\TextColumn::make('créé_le')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('statut')
                    ->options([
                        'ouvert' => 'Ouvert',
                        'en_cours' => 'En cours',
                        'fermé' => 'Fermé',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
