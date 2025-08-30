<?php

namespace App\Filament\User\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Actions;
use Filament\Actions\Action;
use App\Livewire\Traits\PublicTrait;
use App\Models\autistic;
use App\Models\Center;
use App\Models\Family;
use App\Models\Near;
use App\Models\Street;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class createFamily extends Page implements HasForms
{
    use InteractsWithForms,PublicTrait;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.user.pages.create-family';

    protected static ?string $navigationLabel='بيانات عن الأسرة';
    protected ?string $heading=' ';
    protected static ?int $navigationSort=2;
    public static function getNavigationIcon(): string|Htmlable|null
    {
        if (Auth::user()->has_fam)
            return 'heroicon-o-check';
        return 'heroicon-o-x-mark';

    }


    public ?array $data = [];
    public $fam;
    public function mount(): void
    {
        $this->fam=Family::where('user_id',Auth::id())->first();
        if ($this->fam)
            $this->form->fill($this->fam->toArray());
        else
        {

            if (Auth::user()->has_aut)
            $this->form->fill(['father_name'=>Auth::user()->Autistic->surname,'user_id'=>Auth::id()]);
            else $this->form->fill(['user_id'=>Auth::id()]);
        }

    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->model(Family::class)
            ->statePath('data')
            ->components([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Fieldset::make(fn()=>self::ret_html('الأب','my-yellow text-2xl font-black'))
                                    ->schema([
                                        self::getInput('father_name'),
                                        self::getSelect('father_city'),
                                        self::getDate('father_date'),
                                        self::getSelectEnum('father_academic'),
                                        self::getInput('father_job','مهنة الأب'),
                                        self::getSelectEnum('is_father_life','هل الأب على قيد الحياة ؟')
                                            ->afterStateUpdated(function ($state,Set $set){

                                                if ($state==NULL || $state->value==1) {
                                                    $set('father_dead_reason',null);
                                                    $set('father_dead_date',null);
                                                }
                                            }),
                                        self::getInput('father_dead_reason')
                                            ->visible(function (Get $get){return !$get('is_father_life')==NULL && $get('is_father_life')->value==0 ;}),
                                        self::getDate('father_dead_date')
                                            ->visible(function (Get $get){return !$get('is_father_life')==NULL && $get('is_father_life')->value==0 ;}),
                                    ])->columns(1),
                                Fieldset::make(fn()=>self::ret_html('الأم','my-yellow text-2xl font-black'))
                                    ->schema([
                                        self::getInput('mother_name'),
                                        self::getSelect('mother_city'),
                                        self::getDate('mother_date'),
                                        self::getSelectEnum('mother_academic'),
                                        self::getInput('mother_job','مهنة الأم'),
                                        self::getSelectEnum('is_mother_life','هل الأم على قيد الحياة ؟')
                                            ->afterStateUpdated(function ($state,Set $set){
                                                if ($state==NULL || $state->value==1) {
                                                    $set('mother_dead_reason',null);
                                                    $set('mother_dead_date',null);
                                                }
                                            }),
                                        self::getInput('mother_dead_reason')
                                            ->visible(function (Get $get){return $get('is_mother_life')!=NULL && $get('is_mother_life')->value==0;}),
                                        self::getDate('mother_dead_date')
                                            ->visible(function (Get $get){return $get('is_mother_life')!=NULL && $get('is_mother_life')->value==0;}),
                                        self::getInput('number_of_marriages')->numeric()->minValue(1),
                                        self::getInput('number_of_separation')->numeric()->minValue(0),
                                        self::getInput('number_of_pregnancies')->numeric()->minValue(1),
                                        self::getInput('number_of_miscarriages')->numeric()->minValue(0),
                                    ])->columns(1),

                                self::getSelectEnum('is_parent_relationship','هل هناك صلة قرابة بين الأب والأم ؟ '),
                                self::getSelect('father_blood_type','فصيلة دم الأب'),
                                self::getSelect('mother_blood_type','فصيلة دم الأم'),
                                self::getSelectEnum('parent_relationship_nature','ما هي طبيعة العلاقة بين الأب والأم '),

                                self::getInput('brothers_count','عدد الإخوة والأخوات')->numeric()->minValue(0),
                                self::getInput('male_count','عدد الذكور')->numeric()->minValue(0),
                                self::getInput('female_count','عدد الإناث')->numeric()->minValue(0),
                                self::getInput('ser_in_brothers','ترتيب الحالة بين إخوته')->numeric()->minValue(1),
                                Fieldset::make(fn()=>self::ret_html('هل تعرض أحد الوالدين لأمراض مزمنة أو إصابات أخرى ؟','my-yellow text-2xl font-black'))
                                    ->schema([
                                        self::getDiseaseSelect(),
                                        self::getInput('other_diseases','أمراض أخرى')->required(false)
                                    ])
                                    ->columns(1),

                                self::getSelectEnum('family_salary'),
                                self::getSelectEnum('family_sources'),
                                self::getSelectEnum('house_type'),
                                self::getSelectEnum('house_narrow'),
                                self::getSelectEnum('house_health'),
                                self::getSelectEnum('house_old'),
                                self::getSelectEnum('house_own'),
                                self::getSelectEnum('is_house_good'),
                                self::getInput('house_rooms','عدد الحجرات')->numeric()->minValue(1),
                                self::getSelectEnum('is_room_single'),
                                self::getSelectEnum('has_salary','هل يتقاضي الحالة معاش أساسي ؟')
                                    ->afterStateUpdated(function ($state,Set $set){
                                        if ($state==NULL || $state->value==1) $set('why_not_has_salary',null);

                                    }),
                                self::getInput('why_not_has_salary','ما هي الأسباب ؟')
                                    ->visible(function (Get $get){ return !$get('has_salary')==NULL && $get('has_salary')->value!=1 ;}),
                                Textarea::make('other_family_notes')
                                    ->label(fn()=>self::ret_html('معلومات أخرى')),
                                Hidden::make('user_id'),
                                Actions::make([
                                    Action::make('store')
                                        ->requiresConfirmation()
                                        ->action(function (){
                                            if ($this->fam)
                                                $this->fam->update($this->form->getState());

                                            else
                                                Family::create($this->form->getState());
                                            $this->form->model($this->fam)->saveRelationships();

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
                            ->columns(1)
                            ->extraAttributes(['class' => 'greanbackground'])
                    ])
                    ->columns(1)
                    ->columnSpan(3)
            ])->columns(6) ;

    }
}
