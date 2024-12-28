<?php

namespace App\Filament\Admin\Resources\LeadsResource\Pages;

use Filament\Actions;
use App\Imports\Leads;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\LeadsResource;
use App\Models\Leads as ModelsLeads;
use EightyNine\ExcelImport\ExcelImportAction as ImportAction;


class ListLeads extends ListRecords
{
    protected static string $resource = LeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [

            ImportAction::make('Import Leads')
                ->slideOver()
                ->visible(fn() => Auth::user()->role === 'admin')
                ->color("primary")
                ->use(Leads::class),
            Actions\CreateAction::make(),
        ];
    }

}
