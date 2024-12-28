<?php

namespace App\Imports;

use App\Models\Leads as ModelsLeads;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class Leads implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $user = User::where('name', $row[3])->where('role','admin')->first();
            ModelsLeads::create([
                'nama' => $row[0],
                'nomor' => $row[1],
                'alamat' => $row[2],
                'dibuat_oleh' => $user->id,
            ]);
        }
    }
}
