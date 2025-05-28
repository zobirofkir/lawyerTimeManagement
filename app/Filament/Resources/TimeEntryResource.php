<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeEntryResource\Pages;
use App\Models\TimeEntry;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TimeEntryResource extends Resource
{
    protected static ?string $model = TimeEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestion du Temps';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->options(Project::all()->pluck('title', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('task')
                    ->label('Task')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Start Time')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_time')
                    ->label('End Time')
                    ->required(),
                Forms\Components\TextInput::make('duration_minutes')
                    ->label('Duration (Minutes)')
                    ->numeric()
                    ->required(),
                Hidden::make('user_id')
                    ->default(Auth::id())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.title')
                    ->label('Project'),
                Tables\Columns\TextColumn::make('task')
                    ->label('Task'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Start Time')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('End Time')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Duration (Minutes)'),
            ])
            ->filters([
                
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
            // Define relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimeEntries::route('/'),
            'create' => Pages\CreateTimeEntry::route('/create'),
            'edit' => Pages\EditTimeEntry::route('/{record}/edit'),
        ];
    }
}
