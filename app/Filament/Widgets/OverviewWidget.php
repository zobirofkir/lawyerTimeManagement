<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Projects', Project::count())
            ->description('Projects')
            ->descriptionIcon('heroicon-o-shopping-bag')
            ->chart([1, 10, 5, 2, 20, 30, 45])
            ->color('success'),

        Stat::make('Clients', Client::count())
            ->description('Clients')
            ->descriptionIcon('heroicon-o-cube')
            ->chart([1, 10, 5, 2, 20, 30, 45])
            ->color('success'),

        Stat::make('Time', TimeEntry::count())
            ->description('Time')
            ->descriptionIcon('heroicon-o-cube')
            ->chart([1, 10, 5, 2, 20, 30, 45])
            ->color('success'),
        ];
    }
}
