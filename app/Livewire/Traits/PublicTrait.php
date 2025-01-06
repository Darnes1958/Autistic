<?php
namespace App\Livewire\Traits;



use App\Enums\Academic;
use App\Enums\AccLevel;
use App\Enums\Boy_response;
use App\Enums\Health;
use App\Enums\HouseHealth;
use App\Enums\HouseNarrow;
use App\Enums\HouseOld;
use App\Enums\HouseOwn;
use App\Enums\HouseType;
use App\Enums\How_past;
use App\Enums\Person_relationship;
use App\Enums\procedures;
use App\Enums\Relationship_nature;
use App\Enums\Sex;
use App\Enums\Sym_year;
use App\Enums\Symyear;
use App\Enums\With_language;
use App\Enums\With_mind;
use App\Enums\With_motion;
use App\Enums\With_people;
use App\Enums\With_personal;
use App\Enums\YesNo;
use App\Models\City;
use App\Models\Disease;
use App\Models\Rent;
use App\Models\Renttran;
use App\Models\Salary;
use App\Models\Salarytran;

use App\Models\Street;
use Carbon\Carbon;
use DateTime;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

trait PublicTrait {

    protected static function getRadio($name,$label=null): Radio
    {
        if ($name=='sex' ||  $name=='brother_sex') {$label='الجنس';$option=Sex::class;}

        if ($name=='academic' || $name=='father_academic' || $name=='mother_academic' || $name=='brother_academic')
           {$label='المستوي الدراسي';$option=Academic::class;}
        if ($name=='is_father_life' || $name=='is_mother_life') {$label='علي قيد الحياة';$option=YesNo::class;}

        if ($name=='is_parent_relationship') {$label='هل هناك صلة قرابة بين الاب والام ';$option=YesNo::class;}
        if ($name=='parent_relationship_nature') {$label='ما هي طبيعة العلاقة بين الأب والأم ';$option=Relationship_nature::class;}
        if ($name=='brother_health' ) {$label='الحالة الصحية';$option=Health::class;}
        if ($name=='house_type' ) {$label='نوع السكن';$option=HouseType::class;}
        if ($name=='house_narrow' ) {$label='مساحة السكن';$option=HouseNarrow::class;}
        if ($name=='house_health' ) {$label='الحالة الصحية للسكن';$option=HouseHealth::class;}
        if ($name=='house_old' ) {$label='حالة السكن';$option=HouseOld::class;}
        if ($name=='house_own' ) {$label='ملكية السكن';$option=HouseOwn::class;}
        if ($name=='is_house_good' ) {$label='هل تتوفر داخل السكن متطلبات الحياة الأساسية';$option=YesNo::class;}
        if ($name=='is_room_single' ) {$label='هل حجرة الطقل فردية';$option=YesNo::class;}
        if ($name=='how_past' ) {$label='كيف كان وضع الطفل في بداية ظهور الاعراض';$option=How_past::class;}
        if ($name=='with_people' ) {$label='في الجانب الاجتماعي';$option=With_people::class;}
        if ($name=='with_motion' ) {$label='في الجانب الحركي';$option=With_motion::class;}
        if ($name=='with_language' ) {$label='في الجانب اللغوي';$option=With_language::class;}
        if ($name=='with_personal' ) {$label='في جانب العناية الشخصية';$option=With_personal::class;}
        if ($name=='with_mind' ) {$label='في الجانب المعرفي العقلي';$option=With_mind::class;}
        if ($name=='father_procedure' ) {$label='الاب';$option=procedures::class;}
        if ($name=='mother_procedure' ) {$label='الام';$option=procedures::class;}
        if ($name=='brother_procedure' ) {$label='الاخوة';$option=procedures::class;}
        if ($name=='boy_response' ) {$label='مدي استجابة الطفل لأسلوب التعامل';$option=Boy_response::class;}

        return  Radio::make($name)
            ->options($option)
            ->inline()
            ->live()
            ->default(1)
            ->inlineLabel(false)
            ->label($label);
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
        if ($name=='father_job') $l='مهنة الوالد';
        if ($name=='father_dead_reason') $l='سبب الوفاة';
        if ($name=='mother_name') $l='اسم الام';
        if ($name=='mother_job') $l='مهنة الام';
        if ($name=='mother_dead_reason') $l='سبب الوفاة';
        if ($name=='number_of_marriages') $l='عدد مرات الزواج';
        if ($name=='number_of_separation') $l='عدد مرات الانفصال';
        if ($name=='number_of_pregnancies') $l='عدد مرات الحمل';
        if ($name=='number_of_miscarriages') $l='عدد مرات الاجهاض';

        if ($label) $l=$label;

        return TextInput::make($name)
            ->label($l)
            ->required();

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
            ->label($l)
            ->required();

    }
    protected static function getSelectEnum($name,$label=null): Select
    {
        if ( $name=='brother_academic')  {$label='المستوي الدراسي';$option=Academic::class;}
        if ($name=='sym_year') {$l=' تمت رؤية الأعراض في العام ';$option=Sym_year::class;}
        if ($name=='person_relationship') {$l='علاقته بالطفل';$option=Person_relationship::class;}
        if ($name=='family_salary') {$l='الدخل الشهري';$option=\App\Enums\Salary::class;}
        if ($name=='family_sources') {$l='مصادر دخل الأسرة';$option=\App\Enums\Sources::class;}
        if ($label) $l=$label;
        return Select::make($name)
            ->options($option)
            ->default(1)
            ->preload()
            ->searchable()
            ->label($l)
            ->required();
    }

    protected static function getDiseaseSelect()
    {
        return  Select::make('family_disease')
            ->options(Disease::all()->pluck('name', 'id'))
            ->preload()
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
            ->label('هل أصيب أحد أفراد الأسرة بمرض أو حادث معين')->multiple()->columnSpan(2);
    }
    protected static function getSelect($name,$label=null): Select
    {
        if ($name=='birth_city') {$l='محل الميلاد'; $option='Birth_city';$att='name';}
        if ($name=='city_id') {$l='المدينه'; $option='City';$att='name';}
        if ($name=='street_id') {$l='الحي'; $option='Street';$att='name';}
        if ($name=='near_id') {$l='نقطة دالة'; $option='Near';$att='name';}
        if ($name=='center_id') {$l='مركز توحد'; $option='Center';$att='name';}
        if ($name=='person_city') {$l='عنوانه'; $option='Person_city';$att='name';}
        if ($name=='symptom_id') {$l='الاعراض والصعوبات'; $option='Symptom';$att='name';}
        if ($name=='father_city') {$l='محل الميلاد'; $option='Father_city';$att='name';}
        if ($name=='mother_city') {$l='محل الميلاد'; $option='Mother_city';$att='name';}
        if ($name=='ambitious_id') {$l='ما هو طموح الأسرة بالنسبة للطفل'; $option='Ambitious';$att='name';}

        if ($label) $l=$label;

        return Select::make($name)
            ->relationship($option,$att)
            ->preload()
            ->searchable()
            ->label($l)
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


}
