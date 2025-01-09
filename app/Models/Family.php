<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $casts = [
        'family_disease' => 'array',
    ];
    public function Autistic()
    {
        return $this->belongsTo(Autistic::class);
    }
    public function City()
    {
        return $this->belongsTo(City::class);
    }
    public function Disease()
    {
        return $this->belongsTo(Disease::class);
    }
    public function Brother(){
        return $this->hasOne(Brother::class);
    }
    public function FatherCity()
    {
        return $this->belongsTo(City::class, 'father_city');
    }
    public function MotherCity()
    {
        return $this->belongsTo(City::class, 'mother_city');
    }

}
