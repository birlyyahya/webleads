<?php

namespace App\Filament\Admin\Resources\HistoryLeadsResource\Pages;

use App\Models\Leads;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\HistoryLeadsResource;

class CreateHistoryLeads extends CreateRecord
{
    protected static string $resource = HistoryLeadsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $lead = Leads::find($data['lead_id']);

        $lead->ditugaskan_oleh = $data['user_id'];

        if($data['status'] == 'sudah'){
            $lead->status = 'complete';
        }elseif($data['status'] == 'belum'){
            $lead->status = 'pending';
        }elseif($data['status'] == 'ulang'){
            $lead->status = 'ditugaskan';
        }

        $lead->save();

        return $data;
    }
}
