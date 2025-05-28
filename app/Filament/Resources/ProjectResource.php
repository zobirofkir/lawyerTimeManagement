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
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                        Forms\Components\Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'in_progress' => 'In Progress',
                                'closed' => 'Closed',
                            ])
                            ->default('open') 
                            ->required(),
                        Forms\Components\DatePicker::make('start_date')
                            ->nullable(),
                        Forms\Components\DatePicker::make('end_date')
                            ->nullable(),
                        Forms\Components\Select::make('client_id')
                            ->label('Client')
                            ->relationship('client', 'name')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('start_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('end_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'ouvert' => 'Ouvert',
                        'en_cours' => 'En cours',
                        'fermé' => 'Fermé',
                    ]),
                Tables\Filters\Filter::make('client_id')
                    ->label('Client')
                    ->query(fn (Builder $query, array $data) => $query->where('client_id', $data['value']))
                    ->form([
                        Forms\Components\Select::make('value')
                            ->label('Client')
                            ->options(
                                \App\Models\Client::pluck('name', 'id')->toArray()
                            ),
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
