<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Leads;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make("Total Leads", Leads::get()->count())
                ->description('Total Leads')
                ->color('success'),
            Stat::make("Total Complete", Leads::where('status', 'complete')->get()->count())
                ->description('Total Leads selesai di follow up')
                ->color('success'),
            Stat::make("Total Follow up ulang", Leads::where('status', 'ditugaskan')->get()->count())
                ->description('Total Leads perlu di follow up ulang')
                ->color('warning'),
        ];
    }
    public static function canView(): bool
    {
        return Auth::user()->role === 'admin';
    }
}
