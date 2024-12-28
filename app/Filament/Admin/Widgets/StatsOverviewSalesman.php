<?php

namespace App\Filament\Admin\Widgets;

use App\Models\HistoryLeads;
use App\Models\Leads;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewSalesman extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make("Total leads belum di follow up", HistoryLeads::where('status','belum')->get()->count())
                ->description('Total Leads')
                ->color('success'),
            Stat::make("Total sudah di follow up", HistoryLeads::where('status', 'sudah')->get()->count())
                ->description('Total Leads selesai di follow up')
                ->color('success'),
        ];
    }
    public static function canView(): bool
    {
        return Auth::user()->role === 'salesman';
    }
}
