<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'dibuat_oleh' => 'required',
        ]);
        $user = User::where('name', $validated['dibuat_oleh'])->where('role','admin')->first();


        $lead = Leads::create([
            'nama' => $validated['nama'],
            'nomor' => $validated['nomor'],
            'alamat' => $validated['alamat'],
            'dibuat_oleh' => $user->id, // Gunakan ID user
            'status' => 'baru'
        ]);

        $lead->load('user');

        return response()->json([
            'message' => 'Lead created successfully',
            'lead' => $lead,
        ], 201);
    }
}
