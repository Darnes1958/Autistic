<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }   protected $casts = [
    'prescription_image' => 'array',
    'medical_reports' => 'array',
    'therapeutic_reports' => 'array',
    'why_take_medicine' => 'array',
    'therapeutic_details' => 'array',
];

}
