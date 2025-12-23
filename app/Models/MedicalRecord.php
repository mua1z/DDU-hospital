<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'chief_complaint',
        'history_of_present_illness',
        'vital_signs',
        'examination_findings',
        'diagnosis',
        'treatment_plan',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'vital_signs' => 'array',
        'diagnosis' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
