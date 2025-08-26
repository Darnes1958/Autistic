<?php

namespace App\Models;

use App\Enums\BreastPeriod;
use App\Enums\ChildWeight;
use App\Enums\Food;
use App\Enums\Health;
use App\Enums\Play;
use App\Enums\PregnancyNormal;
use App\Enums\PregnancyTime;
use App\Enums\Sleap;
use App\Enums\Symptoms\BehavioralAndEmotional;
use App\Enums\Symptoms\Behaviors;
use App\Enums\Symptoms\Sensory;
use App\Enums\Symptoms\Skills;
use App\Enums\Symptoms\SocialCommunication;
use App\Enums\WhenSpeak;
use App\Enums\WherePregnancy;
use App\Enums\Year;
use App\Enums\YearAndNot;
use App\Enums\Years\CrawlYear;
use App\Enums\YesNo;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Model;


class Growth extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'is_play_with_other' => AsEnumCollection::of(Play::class),
            'social_communication' =>AsEnumCollection::of(SocialCommunication::class),
            'behaviors' => AsEnumCollection::of(Behaviors::class),
            'sensory' => AsEnumCollection::of(Sensory::class),
            'behavioral_and_emotional' => AsEnumCollection::of(BehavioralAndEmotional::class),
            'skills' =>AsEnumCollection::of(Skills::class),

            'mother_p_d_health' => Health::class,
            'is_pregnancy_planned' => YesNo::class,
            'is_p_d_followed' => YesNo::class,
            'is_p_d_good_food' => YesNo::class,
            'is_child_wanted' => YesNo::class,
            'is_p_d_disease' => YesNo::class,
            'is_pregnancy_normal' => PregnancyNormal::class,
            'where_pregnancy_done' => WherePregnancy::class,
            'pregnancy_time'=>PregnancyTime::class,
            'child_weight'=>ChildWeight::class,
            'is_child_followed'=>YesNo::class,
            'is_breastfeeding_natural'=>YesNo::class,
            'breastfeeding_period'=>BreastPeriod::class,
            'difficulties_during_weaning'=>YesNo::class,
            'when_can_set'=>Year::class,
            'teeth_appear'=>Year::class,
            'could_crawl'=>CrawlYear::class,
            'could_stand'=>Year::class,
            'could_walk'=>Year::class,
            'when_try_speak'=>WhenSpeak::class,
            'when_speak'=>WhenSpeak::class,
            'when_open_door'=>YearAndNot::class,
            'when_set_export'=>YearAndNot::class,
            'when_wear_shoes'=>YearAndNot::class,
            'when_use_spoon'=>YearAndNot::class,
            'is_child_food_good'=>Food::class,
            'sleep_habit'=>Sleap::class,
            'is_disturbing_nightmares'=>YesNo::class,
            'safety_of_senses'=>YesNo::class,
            'mental_health'=>YesNo::class,
            'injuries_disabilities'=>YesNo::class,
            'is_child_play_toy'=>YesNo::class,
            'slookea_1'=>YesNo::class,'slookea_5'=>YesNo::class,'slookea_8'=>YesNo::class,
            'slookea_2'=>YesNo::class,'slookea_6'=>YesNo::class,'slookea_9'=>YesNo::class,
            'slookea_3'=>YesNo::class,'slookea_7'=>YesNo::class,'slookea_10'=>YesNo::class,
            'slookea_4'=>YesNo::class,


        ];
    }
    public function BoyDisease()
    {
        return $this->hasMany(BoyDisease::class);
    }
    public function GrowDifficult()
    {
        return $this->hasMany(GrowDifficult::class);
    }


}
