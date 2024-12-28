<?php

namespace App\Filament\Admin\Resources\LeadsResource\Pages;

use App\Filament\Admin\Resources\LeadsResource;
use App\Models\Leads;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;


class CreateLeads extends CreateRecord
{
    protected static string $resource = LeadsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User registered')
            ->body('The user has been created successfully.');
    }
}
