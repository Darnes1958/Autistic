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
    protected ?string $heading='بيانات أولية';

    public static function getNavigationIcon(): string|Htmlable|null
    {
        if (Auth::user()->has_aut)
            return 'heroicon-o-check';
        else return null;

    }
    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->has_aut)
             return 'لم يتم ادخال البيانات';
        else return null;
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger'; // TODO: Change the autogenerated stub
    }

    public ?array $data = [];
    public $aut;
    public function mount(): void
    {
        $this->aut=autistic::where('user_id',Auth::id())->first();
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
                           Fieldset::make('الإسم')
                               ->schema([
                                   self::getInput('name',' ')

                                       ->inlineLabel(false)
                                       ->placeholder('الاسم الأول'),
                                   self::getInput('surname',' ')
                                       ->inlineLabel(false)
                                       ->placeholder('اسم الأب ثلاثي')->columnSpan(2),
                               ])
                               ->columns(3),

                           self::getRadio('sex','النوع'),

                           self::getDate('birthday')

                               ,
                           self::getSelect('birth_city')
                           ,

                           Fieldset::make(fn()=>self::ret_html('العنوان الحالي','my-blue'))
                               ->schema([
                                   self::getSelect('city_id','المدينة')
                                       ->live()
                                       ->afterStateUpdated(function (Set $set,$state){
                                           $set('street_id',null);

                                       }),
                                   self::getSelect('street_id','الحي')
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
                                   self::getSelect('near_id','اقرب نقطة دالة')
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
                           self::getSelect('center_id','مركز التوحد (اذا كان  ملتحقا بمركز)')

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
                           Fieldset::make(fn()=>self::ret_html('الشخص الذي قام بتعبئة البيانات','my-blue'))
                               ->schema([
                                   self::getInput('person_name'),
                                   self::getSelectEnum('person_relationship'),
                                   self::getInput('person_phone'),
                                   self::getSelect('person_city'),
                                   self::getDate('person_date'),
                               ])
                               ->columns(1),
                           self::getInput('symptoms','الاعراض التي تمت ملاحظتها'),
                           self::getSelectEnum('sym_year'),
                           FileUpload::make('image')
                               ->required()
                               ->label('صورة شخصية للحالة')
                               ->multiple()
                               ->directory('autistic-images'),
                            Hidden::make('user_id'),

                            Actions::make([
                                Action::make('store')
                                    ->requiresConfirmation()
                                    ->action(function (){
                                        if ($this->aut)
                                          $this->aut->update($this->form->getState());

                                        else
                                            autistic::create($this->form->getState());

                                        $this->redirect(Dashboard::getUrl());
                                    })
                                    ->label('تخزين'),
                                Action::make('cancel')
                                    ->label('خروج بدون تخزين')
                            ])->alignCenter(),


                       ])
                       ->extraAttributes(['class' => 'greanbackground'])
                   ])
                   ->columns(1)
                   ->columnSpan(1)
            ])->columns(3) ;

    }
}
