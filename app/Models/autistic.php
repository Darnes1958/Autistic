<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class autistic extends Model
{
    protected $appends = ['full_name'];
    public function getFullNameAttribute(){
        return $this->name.' '.$this->surname;
    }
    protected $casts = [
        'symptom_id' => 'array',
    ];
   public function City()
   {
       return $this->belongsTo(City::class);
   }
    public function Street()
    {
        return $this->belongsTo(Street::class);
    }
    public function Center()
    {
        return $this->belongsTo(Center::class);
    }
    public function Family(){
       return $this->hasOne(Family::class);
    }


    public function Near()
    {
        return $this->belongsTo(Near::class);
    }
    public function Person_city()
    {
        return $this->belongsTo(City::class, 'person_city');
    }
    public function Symptom()
    {
        return $this->belongsTo(Symptom::class);
    }

}
