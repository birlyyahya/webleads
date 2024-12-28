<?php

namespace App\Filament\Admin\Resources\LeadsResource\Pages;

use App\Filament\Admin\Resources\LeadsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeads extends EditRecord
{
    protected static string $resource = LeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
