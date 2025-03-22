<?php

namespace App\Models;

use App\Enums\TherapeuticDetails;
use App\Enums\WhyMedicine;
use App\Enums\YesNo;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    protected function casts(): array
    {
        return [
    'prescription_image' => 'array',
    'medical_reports' => 'array',
    'therapeutic_reports' => 'array',
    'why_take_medicine' => AsEnumCollection::of(WhyMedicine::class),
    'therapeutic_details' => AsEnumCollection::of(TherapeuticDetails::class),
    'is_take_medicine'=>YesNo::class,
    'is_take_therapeutic'=>YesNo::class,
    'is_doctor_say'=>YesNo::class,
    'any_problems'=>YesNo::class,
            'is_still_take_medicine'=>YesNo::class,
            'is_there_symptoms'=>YesNo::class,
            'is_medicine_change'=>YesNo::class,
            'is_stil_take_therapeutic'=>YesNo::class,
            'is_there_any_improve'=>YesNo::class,
];
        }

}
