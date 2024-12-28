<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryLeads extends Model
{
    protected $fillable = [
        'lead_id',
        'user_id',
        'email',
        'alamat',
        'pekerjaan',
        'hobi',
        'followup_via',
        'tanggal_followup',
        'status',
        'keterangan',
        'tanggal_followup_lanjutan',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Leads::class, 'lead_id', 'id');
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
