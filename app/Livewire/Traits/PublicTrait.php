<?php
namespace App\Livewire\Traits;



use App\Enums\Academic;
use App\Enums\AccLevel;
use App\Enums\Person_relationship;
use App\Enums\Sex;
use App\Enums\Sym_year;
use App\Enums\Symyear;
use App\Enums\YesNo;
use App\Models\City;
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
        if ($name=='sex') {$label='الجنس';$option=Sex::class;}
        if ($name=='academic') {$label='المستوي الدراسي';$option=Academic::class;}
        if ($name=='father_academic') {$label='المستوي الدراسي';$option=Academic::class;}
        if ($name=='mother_academic') {$label='المستوي الدراسي';$option=Academic::class;}

        if ($name=='is_father_life') {$label='علي قيد الحياة';$option=YesNo::class;}
        if ($name=='is_mother_life') {$label='علي قيد الحياة';$option=YesNo::class;}
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
        if ($name=='city') $l='المدينة';
        if ($name=='person_name') $l='الاسم بالكامل';
        if ($name=='person_phone') $l='هاتف';
        if ($name=='father_name') $l='اسم الأب';
        if ($name=='father_jop') $l='مهنة الوالد';
        if ($name=='father_dead_reason') $l='سبب الوفاة';
        if ($name=='mother_name') $l='اسم الام';
        if ($name=='mother_jop') $l='مهنة الام';
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
        if ($name=='sym_year') {$l=' تمت رؤية الأعراض في العام ';$option=Sym_year::class;}
        if ($name=='person_relationship') {$l='علاقته بالطفل';$option=Person_relationship::class;}
        if ($label) $l=$label;
        return Select::make($name)
            ->options($option)
            ->default(1)
            ->preload()
            ->searchable()
            ->label($l)
            ->required();
    }

    protected static function getSelect($name,$label=null): Select
    {
        if ($name=='birth_city') {$l='محل الميلاد'; $option='City';$att='name';}
        if ($name=='city_id') {$l='المدينه'; $option='City';$att='name';}
        if ($name=='street_id') {$l='الحي'; $option='Street';$att='name';}
        if ($name=='near_id') {$l='نقطة دالة'; $option='Near';$att='name';}
        if ($name=='center_id') {$l='مركز توحد'; $option='Center';$att='name';}
        if ($name=='person_city') {$l='عنوانه'; $option='City';$att='name';}
        if ($name=='symptom_id') {$l='الاعراض والصعوبات'; $option='Symptom';$att='name';}
        if ($name=='father_city') {$l='محل الميلاد'; $option='City';$att='name';}
        if ($name=='mother_city') {$l='محل الميلاد'; $option='City';$att='name';}
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
