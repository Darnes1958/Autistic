<?php

namespace App\Models;

use App\Enums\Academic;
use App\Enums\HouseHealth;
use App\Enums\HouseNarrow;
use App\Enums\HouseOld;
use App\Enums\HouseOwn;
use App\Enums\HouseType;
use App\Enums\Relationship_nature;
use App\Enums\Salary;
use App\Enums\Sources;
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
        'is_parent_relationship'=> YesNo::class,
        'parent_relationship_nature'=> Relationship_nature::class,
        'family_salary'=> Salary::class,
        'family_sources'=>Sources::class,
        'house_type'=>HouseType::class,
        'house_narrow'=>HouseNarrow::class,
        'house_health'=>HouseHealth::class,
        'house_old'=>HouseOld::class,
        'house_own'=>HouseOwn::class,
        'is_house_good'=>YesNo::class,
        'is_room_single'=>YesNo::class,
        'has_salary'=>YesNo::class,
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
