<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LabRequest extends Model
{
    protected $fillable = [
        'request_number',
        'patient_id',
        'appointment_id',
        'requested_by',
        'test_type',
        'test_description',
        'clinical_notes',
        'status',
        'priority',
        'requested_date',
        'due_date',
    ];

    protected $casts = [
        'requested_date' => 'date',
        'due_date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function labResult(): HasOne
    {
        return $this->hasOne(LabResult::class);
    }
}
