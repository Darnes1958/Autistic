<?php

namespace App\Models;

use App\Enums\Academic;
use App\Enums\YesNo;
use Faker\Core\Blood;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [

        'family_disease' => 'array',
        'father_academic'=> Academic::class,
        'mother_academic'=> Academic::class,
        'is_father_life'=> YesNo::class,
        'is_mother_life'=> YesNo::class,
    ];

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
    public function MotherBlood()
    {
        return $this->belongsTo(BloodType::class, 'mother_blood_type');
    }
    public function FatherBlood()
    {
        return $this->belongsTo(BloodType::class, 'father_blood_type');
    }
}
