<?php

namespace App\Filament\User\Pages;

use App\Livewire\Traits\PublicTrait;
use App\Models\autistic;
use App\Models\Center;
use App\Models\Near;
use App\Models\Street;
use App\Models\Symptom;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class createAutistic extends Page implements HasForms
{
    use InteractsWithForms,PublicTrait;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.create-autistic';
    protected static ?string $navigationLabel='بيانات أولية';
    protected ?string $heading=' ';
    protected static ?int $navigationSort=1;

    public static function getNavigationIcon(): string|Htmlable|null
    {
        if (Auth::user()->has_aut)
            return 'heroicon-o-check';
        else return 'heroicon-o-x-mark';

    }


    public ?array $data = [];
    public $aut;
    public function mount(): void
    {
        $this->aut=Autistic::where('user_id',Auth::id())->first();
        if ($this->aut)
           $this->form->fill($this->aut->toArray());
        else
        $this->form->fill(['user_id'=>Auth::id()]);
    }
    public function form(Form $form): Form
    {
        return $form
            ->model(Autistic::class)
            ->statePath('data')
            ->schema([
               Grid::make()
                   ->schema([
                       Section::make()
                       ->schema([
                           Fieldset::make(fn()=>self::ret_html('اسم الحالة رباعي','my-yellow text-2xl font-black'))
                               ->schema([
                                   self::getInput('name',' ')
                                       ->inlineLabel(false)
                                       ->placeholder('الاسم الأول'),
                                   self::getInput('surname',' ')
                                       ->inlineLabel(false)
                                       ->placeholder('اسم الأب ثلاثي')->columnSpan(2),
                               ])
                               ->columns(3),

                           self::getSelectEnum('sex','النوع'),
                           self::getDate('birthday')

                               ,
                           self::getSelect('birth_city')
                           ,

                           Fieldset::make(fn()=>self::ret_html('العنوان الحالي','my-yellow text-2xl font-black'))
                               ->schema([
                                   self::getSelect('city_id','المدينة')
                                       ->live()
                                       ->afterStateUpdated(function (Set $set,$state){
                                           $set('street_id',null);

                                       }),
                                   self::getSelect('street_id','الحي السكني')
                                       ->live()
                                       ->options(fn (Get $get): Collection => Street::query()
                                           ->where('city_id', $get('city_id'))
                                           ->pluck('name', 'id'))
                                       ->disabled(function (Get $get){return $get('city_id')==null; })
                                       ->createOptionUsing(function (array $data,Get $get) : int {
                                           $data['city_id']=$get('city_id');
                                           return Street::create($data)->getKey();
                                       })
                                   ,
                                   self::getSelect('near_id','أقرب نقطة دالة')
                                       ->options(fn (Get $get): Collection => Near::query()
                                           ->where('street_id', $get('street_id'))
                                           ->pluck('name', 'id'))
                                       ->disabled(function (Get $get){return !$get('street_id'); })
                                       ->createOptionUsing(function (array $data,Get $get) : int {
                                           $data['street_id']=$get('street_id');
                                           return Near::create($data)->getKey();
                                       }),
                               ])
                               ->columns(1)
                           ,
                           self::getSelect('center_id','مركز التوحد (إذا كان  ملتحقاً بمركز)')
                               ->label(fn()=>self::ret_html('مركز التوحد (إذا كان  ملتحقاً بمركز)','text-black '))
                               ->required(false)
                               ->options(fn (Get $get): Collection => Center::query()
                                   ->where('city_id', $get('city_id'))
                                   ->pluck('name', 'id'))
                               ->disabled(function (Get $get){return !$get('city_id'); })
                               ->createOptionUsing(function (array $data,Get $get) : int {
                                   $data['city_id']=$get('city_id');
                                   return Center::create($data)->getKey();
                               }),
                           self::getSelectEnum('academic')->columnSpanFull(),
                           Fieldset::make(fn()=>self::ret_html('الشخص الذي قام بتعبئة البيانات','my-yellow text-2xl font-black'))
                               ->schema([
                                   self::getInput('person_name'),
                                   self::getSelectEnum('person_relationship'),
                                   self::getInput('person_phone','رقم الهاتف'),
                                   self::getSelect('person_city','محل الإقامة'),
                                   self::getDate('person_date'),
                               ])
                               ->columns(1),
                           self::getInput('symptoms','الأعراض التي تمت ملاحظتها')
                           ->label(fn()=>self::ret_html('الأعراض التي تمت ملاحظتها ','text-black ')),
                           self::getSelectEnum('sym_year')
                               ->label(fn()=>self::ret_html(' تمت ملاحظة الأعراض في العام ','text-black ')),
                           FileUpload::make('image')
                               ->required()
                               ->label(fn()=>self::ret_html('صورة شخصية للحالة ','my-yellow text-2xl font-black'))
                               ->multiple()
                               ->maxFiles(5)
                               ->directory('autistic-images'),
                            Hidden::make('user_id'),

                            Actions::make([
                                Action::make('store')
                                    ->requiresConfirmation()
                                    ->action(function (){
                                        if ($this->aut)
                                          $this->aut->update($this->form->getState());

                                        else
                                            Autistic::create($this->form->getState());

                                        $this->redirect(Dashboard::getUrl());
                                    })
                                    ->label('حفظ ومتابعة'),
                                Action::make('cancel')
                                    ->action(function (){
                                        $this->redirect(Dashboard::getUrl());
                                    })
                                    ->label('حفظ وخروج')
                            ])->alignCenter(),


                       ])
                       ->extraAttributes(['class' => 'greanbackground'])
                   ])
                   ->columns(1)
                   ->columnSpan(3)
            ])->columns(6) ;

    }
}
