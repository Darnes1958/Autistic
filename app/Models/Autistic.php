<?php

namespace App\Models;

use App\Enums\Person_relationship;
use App\Enums\Sex;
use App\Enums\Sym_year;
use Illuminate\Database\Eloquent\Model;

class Autistic extends Model
{
    protected $appends = ['full_name'];
    public function getFullNameAttribute(){
        return $this->name.' '.$this->surname;
    }
    protected $casts = [
        'image' => 'array',
        'sex' => Sex::class,
        'sym_year' =>Sym_year::class,
        'person_relationship' => Person_relationship::class,
    ];

public function User()
{
    return $this->belongsTo(User::class);
}
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

    public function Brother(){
        return $this->hasOne(Brother::class);
    }

    public function Near()
    {
        return $this->belongsTo(Near::class);
    }
    public function BirthCity()
    {
        return $this->belongsTo(City::class, 'birth_city');
    }
    public function PersonCity()
    {
        return $this->belongsTo(City::class, 'person_city');
    }
    public function Symptom()
    {
        return $this->belongsTo(Symptom::class);
    }

}
