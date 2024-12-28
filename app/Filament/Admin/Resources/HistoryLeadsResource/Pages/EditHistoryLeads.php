<?php

namespace App\Filament\Admin\Resources\HistoryLeadsResource\Pages;

use App\Filament\Admin\Resources\HistoryLeadsResource;
use App\Models\Leads;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistoryLeads extends EditRecord
{
    protected static string $resource = HistoryLeadsResource::class;

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
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $lead = Leads::find($data['lead_id']);

        $lead->ditugaskan_oleh = $data['user_id'];

        if ($data['status'] == 'sudah') {
            $lead->status = 'complete';
        } elseif ($data['status'] == 'belum') {
            $lead->status = 'pending';
        } elseif ($data['status'] == 'ulang') {
            $lead->status = 'ditugaskan';
        }

        $lead->save();

        return $data;
    }
}
