<?php
namespace App\Livewire\Traits;



use App\Enums\Academic;

use App\Enums\Boy_response;
use App\Enums\BreastfeedingNatural;
use App\Enums\BreastPeriod;
use App\Enums\ChildWeight;
use App\Enums\Food;
use App\Enums\Health;
use App\Enums\HouseHealth;
use App\Enums\HouseNarrow;
use App\Enums\HouseOld;
use App\Enums\HouseOwn;
use App\Enums\HouseType;
use App\Enums\How_past;
use App\Enums\Person_relationship;
use App\Enums\Play;
use App\Enums\PregnancyNormal;
use App\Enums\PregnancyTime;
use App\Enums\procedures;
use App\Enums\Relationship_nature;
use App\Enums\RelationsTypes;
use App\Enums\Sex;
use App\Enums\Sleap;
use App\Enums\Sym_year;

use App\Enums\Symptoms\BehavioralAndEmotional;
use App\Enums\Symptoms\Behaviors;
use App\Enums\Symptoms\Sensory;
use App\Enums\Symptoms\Skills;
use App\Enums\Symptoms\SocialCommunication;
use App\Enums\TherapeuticDetails;
use App\Enums\Weekly;
use App\Enums\WhenSpeak;
use App\Enums\WherePregnancy;
use App\Enums\WhyMedicine;
use App\Enums\With_language;
use App\Enums\With_mind;
use App\Enums\With_motion;
use App\Enums\With_people;
use App\Enums\With_personal;
use App\Enums\Year;
use App\Enums\YearAndNot;
use App\Enums\Years\CrawlYear;
use App\Enums\YesNo;
use App\Models\City;
use App\Models\Disease;

use App\Models\Street;
use Carbon\Carbon;
use DateTime;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Symfony\Component\Console\Input\Input;

trait PublicTrait {

    protected static function  ret_html($text,$c='text-lg text-black')
    {
        return  new HtmlString('<span class="   '.$c.'">'.$text.'</span>');
    }
    protected static function getCheck($name,$label=null): CheckboxList
    {
        $option=null;

        if ($name=='how_past' ) {$l='كيف كان وضع الحالة في بداية ظهور الاعراض ?';$option=How_past::class;}


        if ($name=='why_take_medicine' ) {$option=WhyMedicine::class;}
        if ($name=='therapeutic_details' ) {$option=TherapeuticDetails::class;}


        if ($label) $l=$label;

        return  CheckboxList::make($name)
            ->options($option)
            ->validationMessages([
                'required' => 'يجب اختيار : '.$label,
                'requiredif' => 'يجب اختيار : '.$label,
            ])

            ->required()
            ->label(fn()=>self::ret_html($l));

    }
    protected static function getRadio($name,$label=null): Radio
    {
        $option=null;
        if ($name=='sex' ||  $name=='brother_sex') {$l='النوع';$option=Sex::class;}

        if ($name=='is_parent_relationship') {$l='هل هناك صلة قرابة بين الاب والام ? ';$option=YesNo::class;}

        if ($name=='brother_health' ) {$l='الحالة الصحية';$option=Health::class;}
        if ($name=='house_type' ) {$l='نوع السكن';$option=HouseType::class;}
        if ($name=='house_narrow' ) {$l='مساحة السكن';$option=HouseNarrow::class;}
        if ($name=='house_health' ) {$l='الحالة الصحية للسكن';$option=HouseHealth::class;}
        if ($name=='house_old' ) {$l='حالة السكن';$option=HouseOld::class;}
        if ($name=='house_own' ) {$l='ملكية السكن';$option=HouseOwn::class;}
        if ($name=='is_house_good' ) {$l='هل تتوفر داخل السكن متطلبات الحياة الأساسية ?';$option=YesNo::class;}
        if ($name=='is_room_single' ) {$l='هل حجرة الحالة فردية ?';$option=YesNo::class;}
        if ($name=='mother_p_d_health' ) {$l='حالة الام الصحية اثناء الحمل';$option=Health::class;}
        if ($name=='is_breastfeeding_natural' ) {$l='هل كانت الرضاعة طبيعية ?';$option=BreastfeedingNatural::class;}
        if ($name=='is_child_food_good' ) {$l='كيف كانت تغذية الحالة ?';$option=Food::class;}
        if ($name=='sleep_habit' ) {$l='ما عادات الحالة في النوم ؟';$option=Sleap::class;}
        if ($name=='weekly_therapeutic' ) {$option=Weekly::class;}

        if ($label) $l=$label;
        if (!$option) $option=YesNo::class;

        return  Radio::make($name)
            ->options($option)
            ->inline()
            ->live()
            ->required()
            ->label(fn()=>self::ret_html($l));
    }
    protected static function getColumn($name): TextColumn
    {
        if ($name=='name') $label='الاسم';
        if ($name=='full_name') $label='الاسم';
        if ($name=='City.name') $label='المدينة';
        if ($name=='person_name') $label='تعبئة البيانات بمعرفة';

        return TextColumn::make($name)
            ->label($label)
            ->searchable()
            ->sortable();

    }

    protected static function getInput($name,$label=null): TextInput
    {
        if ($name=='name') $l='الاسم';
        if ($name=='person_phone') $l='هاتف';
        if ($name=='surname') $l='اسم الأب ثلاثي';

        if ($name=='person_name') $l='الاسم بالكامل';
        if ($name=='person_phone') $l='هاتف';
        if ($name=='father_name') $l='اسم الأب';
        if ($name=='father_job') $l='مهنة الاب';
        if ($name=='father_dead_reason') $l='سبب الوفاة';
        if ($name=='mother_name') $l='اسم الأم';
        if ($name=='mother_job') $l='مهنة الام';
        if ($name=='mother_dead_reason') $l='سبب الوفاة';
        if ($name=='number_of_marriages') $l='عدد مرات الزواج';
        if ($name=='number_of_separation') $l='عدد مرات الإنفصال';
        if ($name=='number_of_pregnancies') $l='عدد مرات الحمل';
        if ($name=='number_of_miscarriages') $l='عدد مرات الإجهاض';

        if ($label) $l=$label;

        return TextInput::make($name)
            ->label(fn()=>self::ret_html($l))
            ->inlineLabel()
            ->validationMessages([
                'required' => 'يجب ادخال : '.$label,
                'requiredif' => 'يجب ادخال : '.$label,
            ])
            ->required();

    }
    protected static function getArea($name,$label=null): Textarea
    {
        $l=null;
        if ($label) $l=$label;

        return Textarea::make($name)
            ->label(fn()=>self::ret_html($l))
            ->required();
    }
    protected static function getEntry($name,$label=null): TextEntry
    {
        $l=null;
        if ($label) $l=$label;

        return TextEntry::make($name)
            ->label(fn()=>self::ret_html($l));
    }

    protected static function getDate($name,$label=null): DatePicker
    {
        if (!$label) $l='التاريخ';

        if ($name=='birthday') $l='تاريخ الميلاد';
        if ($name=='person_date') $l='تاريخ التعبئة';
        if ($name=='father_date') $l='تاريخ الميلاد';
        if ($name=='father_dead_date') $l='تاريخ الوفاة';
        if ($name=='mother_date') $l='تاريخ الميلاد';
        if ($name=='mother_dead_date') $l='تاريخ الوفاة';

        if ($label) $l=$label;

        return DatePicker::make($name)
            ->label(fn()=>self::ret_html($l))
            ->validationMessages([
                'required' => 'يجب ادخال : '.$label,
                'requiredif' => 'يجب ادخال : '.$label,
            ])

            ->inlineLabel()
            ->required();

    }
    protected static function getSelectEnumMulti($name,$label=null,$inline=true): Select
    {

        if ($label) $l=$label;
        if ($name=='how_past' ) {$l='كيف كان وضع الحالة في بداية ظهور الاعراض ?';$option=How_past::class;}
        if ($name=='is_play_with_other') {$l='مع من يفضل الحالة اللعب ؟ ';$option=Play::class;}
        if ($name=='social_communication' ) {$option=SocialCommunication::class;}
        if ($name=='behaviors' ) {$option=Behaviors::class;}
        if ($name=='sensory' ) {$option=Sensory::class;}
        if ($name=='behavioral_and_emotional' ) {$option=BehavioralAndEmotional::class;}
        if ($name=='skills' ) {$option=Skills::class;}

        return Select::make($name)
            ->options($option)
            ->placeholder('بإمكانك اختيار أكثر من إجابة')
            ->live()
            ->preload()
            ->searchable()
            ->label(fn()=>self::ret_html($l))
            ->inlineLabel($inline)
            ->multiple()
            ->required();
    }

    protected static function getSelectEnum($name,$label=null): Select
    {
        $option=null;

        if ($name=='academic' || $name=='father_academic' || $name=='mother_academic' || $name=='brother_academic')
        {$l='المستوي الدراسي';$option=Academic::class;}




        if ($name=='is_parent_relationship') {$l='هل هناك صلة قرابة بين الاب والام ? ';$option=YesNo::class;}

        if ($name=='brother_health' ) {$l='الحالة الصحية';$option=Health::class;}
        if ($name=='house_type' ) {$l='نوع السكن';$option=HouseType::class;}
        if ($name=='house_narrow' ) {$l='مساحة السكن';$option=HouseNarrow::class;}
        if ($name=='house_health' ) {$l='الحالة الصحية للسكن';$option=HouseHealth::class;}
        if ($name=='house_old' ) {$l='حالة السكن';$option=HouseOld::class;}
        if ($name=='house_own' ) {$l='ملكية السكن';$option=HouseOwn::class;}
        if ($name=='is_house_good' ) {$l='هل تتوفر داخل السكن متطلبات الحياة الأساسية ?';$option=YesNo::class;}
        if ($name=='is_room_single' ) {$l='هل حجرة الحالة فردية ?';$option=YesNo::class;}
        if ($name=='mother_p_d_health' ) {$l='حالة الام الصحية اثناء الحمل';$option=Health::class;}
        if ($name=='is_breastfeeding_natural' ) {$l='هل كانت الرضاعة طبيعية ?';$option=BreastfeedingNatural::class;}
        if ($name=='is_child_food_good' ) {$l='كيف كانت تغذية الحالة ?';$option=Food::class;}
        if ($name=='sleep_habit' ) {$l='ما عادات الحالة في النوم ؟';$option=Sleap::class;}
        if ($name=='weekly_therapeutic' ) {$option=Weekly::class;}

        if ($name=='sex' ) {$l='النوع';$option=Sex::class;}
        if ($name=='parent_relationship_nature') {$l='ما هي طبيعة العلاقة بين الأب والأم ';$option=Relationship_nature::class;}

        if ($name=='with_people' ) {$l='في الجانب الإجتماعي';$option=With_people::class;}
        if ($name=='with_motion' ) {$l='في الجانب الحركي';$option=With_motion::class;}
        if ($name=='with_language' ) {$l='في الجانب اللغوي';$option=With_language::class;}
        if ($name=='with_personal' ) {$l='في جانب العناية الشخصية';$option=With_personal::class;}
        if ($name=='with_mind' ) {$l='في الجانب المعرفي العقلي';$option=With_mind::class;}

        if ($name=='father_procedure' ) {$l='الأب';$option=procedures::class;}
        if ($name=='mother_procedure' ) {$l='الأم';$option=procedures::class;}
        if ($name=='brother_procedure' ) {$l='الإخوة';$option=procedures::class;}

        if ($name=='boy_response' ) {$l='مدى استجابة الحالة لأسلوب التعامل';$option=Boy_response::class;}

        if ($name=='is_pregnancy_normal' ) {$l='هل كانت الولادة طبيعية';$option=PregnancyNormal::class;}
        if ($name=='where_pregnancy_done' ) {$l='أين تمت عملية الولادة';$option=WherePregnancy::class;}
        if ($name=='pregnancy_time' ) {$l='ما الوقت الذي استغرقته عملية الولادة';$option=PregnancyTime::class;}


        if ($name=='brother_relation') {$l='اتجاه وعلاقته بالحالة ';$option=RelationsTypes::class;}
        if ($name=='sym_year') {$l=' تمت رؤية الأعراض في العام ';$option=Sym_year::class;}
        if ($name=='person_relationship') {$l='علاقته بالحالة';$option=Person_relationship::class;}
        if ($name=='family_salary') {$l='الدخل الشهري';$option=\App\Enums\Salary::class;}
        if ($name=='family_sources') {$l='مصادر دخل الأسرة';$option=\App\Enums\Sources::class;}

        if ($name=='child_weight' ) {$l='وزن الحالة اثناء الولادة';$option=ChildWeight::class;}
        if ($name=='breastfeeding_period' ) {$l='مدة الرضاعة';$option=BreastPeriod::class;}
        if ($name=='when_can_set' ) {$l='متى استطاع الجلوس';$option=Year::class;}
        if ($name=='teeth_appear' ) {$l='متى بدأت الاسنان بالظهور';$option=Year::class;}
        if ($name=='could_crawl' ) {$l='متى استطاع الحبو (الزحف)';$option=CrawlYear::class;}
        if ($name=='could_stand' ) {$l='متى استطاع الوقوف';$option=Year::class;}
        if ($name=='could_walk' ) {$l='متى استطاع المشي';$option=Year::class;}
        if ($name=='when_try_speak' ) {$l='متى بدأت محاولة النطق';$option=WhenSpeak::class;}
        if ($name=='when_speak' ) {$l='متى استطاع التحدث';$option=WhenSpeak::class;}
        if ($name=='when_open_door' ) {$l='متى استطاع فتح الابواب';$option=YearAndNot::class;}
        if ($name=='when_set_export' ) {$l='متى ضبط عمليات الاخراج';$option=YearAndNot::class;}
        if ($name=='when_wear_shoes' ) {$l='متى استطاع ان يلبس الحذاء';$option=YearAndNot::class;}
        if ($name=='when_use_spoon' ) {$l='متى استطاع استخدام الملعقة و الكوب';$option=YearAndNot::class;}

        if ($label) $l=$label;
        if (!$option) $option=YesNo::class;
        return Select::make($name)
            ->options($option)
            ->validationMessages([
                'required' => 'يجب اختيار : '.$label,
                'requiredif' => 'يجب اختيار : '.$label,
            ])

            ->live()
            ->preload()
            ->searchable()
            ->label(fn()=>self::ret_html($l))
            ->inlineLabel()
            ->required();
    }

    protected static function getDiseaseSelect()
    {
        return  Select::make('family_disease')
            ->options(Disease::all()->pluck('name', 'id'))

            ->preload()
            ->inlineLabel()
            ->searchable()
            ->createOptionForm([
                TextInput::make('name')
                    ->required()
                    ->unique()
                    ->label('اسم المرض'),
                Hidden::make('user_id')
                    ->default(Auth::id()),
            ])
            ->createOptionUsing(function (array $data): int {
                return Disease::create($data)->getKey();
            })
            ->editOptionForm([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('المرض'),
            ])
            ->label(fn()=>self::ret_html('قائمة بالأمراض'))
            ->multiple();
    }
    protected static function getSelect($name,$label=null): Select
    {
        if ($name=='birth_city') {$l='محل الميلاد'; $option='BirthCity';$att='name';}
        if ($name=='city_id') {$l='المدينه'; $option='City';$att='name';}
        if ($name=='street_id') {$l='الحي'; $option='Street';$att='name';}
        if ($name=='near_id') {$l='نقطة دالة'; $option='Near';$att='name';}
        if ($name=='center_id') {$l='مركز توحد'; $option='Center';$att='name';}
        if ($name=='person_city') {$l='عنوانه'; $option='PersonCity';$att='name';}
        if ($name=='symptom_id') {$l='الاعراض والصعوبات'; $option='Symptom';$att='name';}
        if ($name=='father_city') {$l='محل الميلاد'; $option='FatherCity';$att='name';}
        if ($name=='mother_city') {$l='محل الميلاد'; $option='MotherCity';$att='name';}
        if ($name=='ambitious_id') {$l='ما هو طموح الأسرة بالنسبة للطفل'; $option='Ambitious';$att='name';}
        if ($name=='disease_menu_id') {$l='المرض'; $option='DiseaseMenu';$att='name';}
        if ($name=='grow_difficult_menu_id') {$l='الصعوبة'; $option='GrowDifficultMenu';$att='name';}
        if ($name=='medicine_id') {$l='اسم الدواء'; $option='Medicine';$att='name';}
        if ($name=='father_blood_type') {$l='فصيلة دم الاب'; $option='FatherBlood';$att='name';}
        if ($name=='mother_blood_type') {$l='فصيلة دم الام'; $option='MotherBlood';$att='name';}


        if ($label) $l=$label;

        return Select::make($name)
            ->relationship($option,$att)
            ->preload()
            ->searchable()
            ->label(fn()=>self::ret_html($l))

            ->inlineLabel()
            ->createOptionForm([
                        TextInput::make($att)
                            ->required()
                            ->unique()
                            ->label($l),
                        Hidden::make('user_id')
                          ->default(Auth::id()),
            ])
            ->editOptionForm([
                        TextInput::make($att)
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label($l),
            ])
            ->required();
    }

public static function noti_danger($label)
{
    return                                 Notification::make()
        ->title(new HtmlString('<span class="my-yellow">'.$label.'</span>'))
        ->danger()
        ->icon('heroicon-o-exclamation-triangle')
        ->iconColor('danger')
        ->iconSize(IconSize::Large)
        ->send();

}
}
