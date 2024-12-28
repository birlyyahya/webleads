<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leads extends Model
{
    protected $fillable = [
        'nama',
        'nomor',
        'alamat',
        'dibuat_oleh',
        'ditugaskan_oleh',
        'status',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh','id');
    }
    public function histories(): HasMany
    {
        return $this->hasMany(HistoryLeads::class, 'lead_id', 'id');
    }

}
