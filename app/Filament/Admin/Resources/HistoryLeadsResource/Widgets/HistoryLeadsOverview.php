<?php

namespace App\Filament\Admin\Resources\HistoryLeadsResource\Widgets;

use App\Models\HistoryLeads;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class HistoryLeadsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total leads belum di follow up", HistoryLeads::where('status', 'belum')->get()->count())
                ->description('Total Leads')
                ->color('success'),
            Stat::make("Total anda sudah di follow up", HistoryLeads::where('status', 'sudah')->where('user_id',Auth::user()->id)->get()->count())
                ->description('Total Leads selesai di follow up')
                ->color('success'),
        ];
    }
}
