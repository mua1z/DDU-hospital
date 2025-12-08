<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabResult extends Model
{
    protected $fillable = [
        'lab_request_id',
        'patient_id',
        'processed_by',
        'results',
        'test_values',
        'findings',
        'recommendations',
        'status',
        'test_date',
        'result_date',
        'result_file',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'test_values' => 'array',
        'test_date' => 'date',
        'result_date' => 'date',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function labRequest(): BelongsTo
    {
        return $this->belongsTo(LabRequest::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
