<?php

namespace App\Filament\Admin\Resources\HistoryLeadsResource\Pages;

use App\Filament\Admin\Resources\HistoryLeadsResource;
use App\Models\Leads;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListHistoryLeads extends ListRecords
{
    protected static string $resource = HistoryLeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Followed up' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'sudah'))
                ->badge(Leads::where('status', 'complete')->where('ditugaskan_oleh', Auth::user()->id)->count())
                ->badgeColor('info'),
            'Unsigned' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'baru')->orWhere('status', 'pending'))
                ->badge(Leads::query()->where('status', 'baru')->orWhere('status', 'pending')->whereNull('ditugaskan_oleh')->count())
                ->badgeColor('warning'),
            'Follow Up Lanjutan' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->Where('status', 'ulang')->where('user_id', Auth::user()->id))
                ->badge(Leads::query()->Where('status', 'pending')->where('ditugaskan_oleh', Auth::user()->id)->count())
                ->badgeColor('warning'),
        ];
    }
}
