<?php

namespace App\Filament\User\Pages;

use App\Livewire\Traits\PublicTrait;
use App\Models\Boy;
use App\Models\Growth;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class createGrowth extends Page implements HasForms
{
    use InteractsWithForms,PublicTrait;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.create-growth';

    protected static ?string $navigationLabel='تاريخ النمو';
    protected ?string $heading=' ';
    protected static ?int $navigationSort=4;
    public static function getNavigationIcon(): string|Htmlable|null
    {
        if (Auth::user()->has_grow)
            return 'heroicon-o-check';
        return 'heroicon-o-x-mark';

    }

    public ?array $data = [];
    public $growth;

    public function mount(): void
    {
        $this->growth=Growth::where('user_id',Auth::id())->first();
        if ($this->growth)
            $this->form->fill($this->growth->toArray());
        else
        {

            $this->form->fill(['user_id'=>Auth::id()]);
        }

    }
    public function form(Form $form): Form
    {
        return $form
            ->model(Growth::class)
            ->statePath('data')
            ->schema([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                self::getInput('mother_old','عمر الأم عند ولادة الحالة')
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state>55 || $state<16) {
                                            $set('mother_old', null);
                                            self::noti_danger('يجب أن يكون عمر الأم عند الولادة من 16 الي 55');
                                        }
                                    })
                                    ->minValue(16)
                                    ->maxValue(55),
                                self::getInput('pregnancy_duration','مدة الحمل')
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state<5 || $state>12) {
                                            $set('pregnancy_duration', null);
                                            self::noti_danger('يجب أن تكون مدة الحمل من 5 الي 12');
                                        }
                                    })
                                    ->minValue(5)
                                    ->maxValue(12),
                                self::getSelectEnum('is_pregnancy_planned','هل كان الحمل مخططا له'),
                                self::getSelectEnum('mother_p_d_health','حالة الأم الصحية أثناء الحمل')->live()
                                ->afterStateUpdated(function (Set $set, $state){
                                    if ($state=1) $set('p_d_why_not_health',null);
                                }),
                                self::getInput('p_d_why_not_health','لماذا كانت غير جيدة')
                                    ->visible(fn(Get $get): bool => $get('mother_p_d_health')!=null && $get('mother_p_d_health')==0)
                                    ->nullable(),
                                self::getSelectEnum('is_p_d_followed','هل تم الحمل بمتابعة طبية'),
                                self::getSelectEnum('is_p_d_good_food','هل غذاء الأم اثناء الحمل جيد'),
                                self::getSelectEnum('is_child_wanted','هل كان الحالة مرغوب فيه'),
                                self::getSelectEnum('is_p_d_disease','هل تعرضت الأم لأي أمراض أو حوادث')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state!=1) $set('p_d_disease',null);
                                    }),
                                self::getInput('p_d_disease',' ماهي الأمراض أو الحوادث التي نعرضت إليها الأم')
                                    ->nullable()
                                    ->requiredIf('is_p_d_disease', 1)
                                    ->visible(fn(Get $get): bool =>$get('is_p_d_disease')==1),
                                Grid::make()
                                    ->schema([
                                        self::getSelectEnum('is_pregnancy_normal','هل كانت الولادة طبيعية'),
                                        self::getSelectEnum('where_pregnancy_done','أين تمت عملية الولادة'),
                                        self::getSelectEnum('pregnancy_time','ما الوقت الذي استغرقته عملية الولادة'),
                                        self::getSelectEnum('child_weight','وزن الحالة أثناء الولادة'),
                                        self::getSelectEnum('is_child_followed','هل احتاج الحالة بعد الولادة إلى رعاية خاصة')
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, $state){
                                                if ($state!=1) $set('why_child_followed',null);
                                            }),

                                        self::getinput('why_child_followed','لماذا احتاج لرعاية')
                                            ->visible(fn(Get $get):bool =>$get('is_child_followed')==1)
                                            ->nullable(),
                                    ])->columns(1),


                                self::getSelectEnum('is_breastfeeding_natural','هل كانت الرضاعة طبيعية ?'),
                                self::getSelectEnum('breastfeeding_period','مدة الرضاعة'),
                                self::getSelectEnum('difficulties_during_weaning','هل حدثت صعوبات أثناء الفطام')
                                ->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state!=1) $set('what_is_the_defficulties',null);
                                    }),

                                self::getinput('what_is_the_defficulties','ما هي الصعوبات ؟')
                                    ->visible(fn(Get $get):bool =>$get('difficulties_during_weaning')==1)
                                    ->nullable(),
                                self::getSelectEnum('when_can_set','متى استطاع الجلوس'),
                                self::getSelectEnum('teeth_appear','متى بدأت الاسنان بالظهور'),
                                self::getSelectEnum('could_crawl','متى استطاع الحبو (الزحف)'),
                                self::getSelectEnum('could_stand','متى استطاع الوقوف'),
                                self::getSelectEnum('could_walk','متى استطاع المشي'),
                                self::getSelectEnum('when_try_speak','متى بدأت محاولة النطق'),
                                self::getSelectEnum('when_speak','متى استطاع التحدث'),
                                self::getSelectEnum('when_open_door','متى استطاع فتح الأبواب'),
                                self::getSelectEnum('when_set_export','متى ضبط عمليات الإخراج'),
                                self::getSelectEnum('when_wear_shoes','متى استطاع أن يلبس الحذاء'),
                                self::getSelectEnum('when_use_spoon','متى استطاع استخدام الملعقة و الكوب'),
                                self::getSelectEnum('is_child_food_good','كيف كانت تغذية الحالة ?')->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state==1) $set('why_food_not_good',null);
                                    }),

                                self::getinput('why_food_not_good','اسباب التغذية الغير جيدة')
                                    ->visible(fn(Get $get):bool =>  $get('is_child_food_good')==2),

                                self::getSelectEnum('sleep_habit','ما عادات الحالة في النوم ؟'),
                                self::getSelectEnum('is_disturbing_nightmares','هل يتعرض لكوابيس مزعجة'),
                                self::getSelectEnum('safety_of_senses','هل الحواس سليمة')
                                ->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state==1) $set('who_senses',null);
                                    }),

                                self::getinput('who_senses','ماهي الحواس المصابة')
                                    ->visible(fn(Get $get):bool => $get('safety_of_senses')!=null && $get('safety_of_senses')==0)->nullable(),
                                self::getSelectEnum('mental_health','هل الوظائف العقلية سليمة')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state==1) $set('who_mental',null);
                                    }),

                                self::getInput('who_mental','ماهي الوظائف المصابة')
                                    ->visible(fn(Get $get):bool => $get('mental_health')!=null && $get('mental_health')==0)->nullable(),
                                self::getSelectEnum('injuries_disabilities','هل توجد إصابات أو عاهات جسيمة')
                                ->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state!=1) $set('injuries_type',null);
                                    }),

                                self::getInput('injuries_type','ما نوع الاصابة ؟')
                                    ->visible(fn(Get $get):bool
                                    =>  $get('injuries_disabilities')==1)
                                    ->nullable(),


                                self::getSelectEnum('is_child_play_toy','هل يمارس الحالة اللعب بالألعاب')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state==1) $set('why_not_play_toy',null);
                                    }),
                                self::getInput('why_not_play_toy','لماذا لا يمارس اللعب بالالعاب ؟')
                                    ->visible(fn(Get $get):bool => $get('is_child_play_toy')!=null
                                        && $get('is_child_play_toy')==0)
                                    ->nullable(),
                                self::getSelectEnumMulti('is_play_with_other','مع من يفضل الحالة اللعب ؟ '),

                                self::getSelectEnum('slookea_1','هل الحالة يستمتع بأن يتأرجح ويتمايل'),
                                self::getSelectEnum('slookea_2','هل الحالة مهتم بالآخرين'),
                                self::getSelectEnum('slookea_3','هل الحالة يتسلق الأشياء مثل السلالم وما شابه'),
                                self::getSelectEnum('slookea_4','هل الحالة يمارس ألعاب الأطفال مثل لعبة الإستغماية (التخفي)'),
                                self::getSelectEnum('slookea_5','هل يمارس الحالة (اللعب التخيلي) كأن يقوم بعمل الشاي باستخدام أكواب وأدوات أثناء اللعب '),
                                self::getSelectEnum('slookea_6','هل يستخدم الحالة إصبعه ليشير إلى أشياء يريد أن يسألك عنها'),
                                self::getSelectEnum('slookea_7','هل يستخدم الحالة إصبعه ليشير إلى أشياء هو مهتم بها'),
                                self::getSelectEnum('slookea_8','هل يُحضر لك الحالة أشياء لكي يريها لك'),

                                self::getSelectEnum('slookea_9','هل يقوم الحالة بالدوران حول نفسه'),
                                self::getSelectEnum('slookea_10','هل يسير علي أطراف الأصابع'),

                                self::getInput('slookea_other','مظاهر سلوكية أخرى'),

                                Fieldset::make(fn()=>self::ret_html(' أبرز الأعراض الظاهرة على الحالة','my-yellow text-2xl font-black'))
                                    ->schema([
                                        self::getSelectEnumMulti('social_communication','صعوبات في التواصل الاجتماعي')->inlineLabel(false)->required(false),
                                        self::getSelectEnumMulti('behaviors','سلوكيات نمطية ومتكررة')->required(false)->inlineLabel(false),
                                        self::getSelectEnumMulti('sensory','مشكلات حسية')->required(false)->inlineLabel(false),
                                        self::getSelectEnumMulti('behavioral_and_emotional','مشكلات سلوكية وعاطفية')->required(false)->inlineLabel(false),
                                        self::getSelectEnumMulti('skills','مشكلات في المهارات المعرفية والتعلم')->required(false)->inlineLabel(false),
                                        self::getArea('other_sym','أعراض أخرى')->required(false),
                                    ])->columns(1),
                            ])
                            ->columns(1)
                            ->extraAttributes(['class' => 'greanbackground']),
                    ])
                    ->columns(1)
                    ->columnSpan(3),
                Grid::make()
                 ->schema([
                     Section::make()
                         ->schema([
                             TableRepeater::make('GrowDifficult')
                                 ->columnSpanFull()
                                 ->label(fn()=>self::ret_html('صعوبات نمائية أخرى تذكر',' text-base'))
                                 ->streamlined()
                                 ->emptyLabel(false)
                                 ->relationship()
                                 ->headers([
                                     Header::make('الصعوبة')
                                         ->label(fn()=>self::ret_html('الصعوبة',' text-base my-yellow'))
                                         ->width('30%'),
                                     Header::make('العمر')
                                         ->label(fn()=>self::ret_html('العمر',' text-base my-yellow'))
                                         ->width('10%'),
                                     Header::make('الاجراءات التي اتخذت')
                                         ->label(fn()=>self::ret_html('الاجراءات التي اتخذت',' text-base my-yellow'))
                                         ->width('60%'),

                                 ])
                                 ->live()
                                 ->defaultItems(0)
                                 ->addActionLabel('إضافة صعوبة')
                                 ->schema([
                                     self::getSelect('grow_difficult_menu_id',' ')->inlineLabel(false),
                                     self::getInput('age',' ')->inlineLabel(false),
                                     self::getInput('procedures',' ')->inlineLabel(false),

                                 ])
                                 ->addable(function ($state){
                                     $flag=true;
                                     if ($state!=null)
                                         foreach ($state as $item) {
                                             if (!$item['grow_difficult_menu_id'] || !$item['age']  || !$item['procedures']) {$flag=false; break;}
                                         }
                                     return $flag;
                                 }),

                         ])
                         ->extraAttributes(['class' => 'greanbackground']),

                 ])
                ->columnSpanFull(),

                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TableRepeater::make('BoyDisease')
                                    ->streamlined()
                                    ->columnSpanFull()
                                    ->label(fn()=>self::ret_html('قائمة بأبرز الأمراض التي أصيب بها الحالة'))
                                    ->relationship()
                                    ->headers([
                                        Header::make('المرض')
                                            ->label(fn()=>self::ret_html('المرض','text-sm my-yellow '))
                                            ->width('30%'),
                                        Header::make('العمر عند الإصابة')
                                            ->label(fn()=>self::ret_html('العمر عند الإصابة','text-sm my-yellow'))
                                            ->width('10%'),
                                        Header::make('مدة المرض')
                                            ->label(fn()=>self::ret_html('مدة المرض','text-sm my-yellow'))
                                            ->width('10%'),
                                        Header::make('شدته')
                                            ->label(fn()=>self::ret_html('شدته','text-sm my-yellow'))
                                            ->width('20%'),
                                        Header::make('العلاج')
                                            ->label(fn()=>self::ret_html('العلاج','text-sm my-yellow'))
                                            ->width('25%'),

                                    ])
                                    ->live()
                                    ->streamlined()
                                    ->emptyLabel(false)
                                    ->defaultItems(0)
                                    ->addActionLabel('إضافة مرض')
                                    ->schema([
                                        self::getSelect('disease_menu_id',' ')->inlineLabel(false),
                                        self::getInput('age',' ')->inlineLabel(false),
                                        self::getInput('period',' ')->inlineLabel(false),
                                        self::getInput('intensity',' ')->inlineLabel(false),
                                        self::getInput('treatment',' ')->inlineLabel(false),
                                    ])
                                    ->addable(function ($state){
                                        $flag=true;
                                        if ($state!=null)
                                            foreach ($state as $item) {
                                                if (!$item['disease_menu_id'] || !$item['age']  || !$item['period']
                                                    || !$item['intensity'] || !$item['treatment']) {$flag=false; break;}
                                            }
                                        return $flag;
                                    }),

                            ])
                            ->extraAttributes(['class' => 'greanbackground']),


                    ])
                    ->columnSpanFull(),

                Hidden::make('user_id'),

                Actions::make([
                    Action::make('store')
                        ->requiresConfirmation()
                        ->action(function (){

                            if ($this->growth)
                                $this->growth->update($this->form->getState());

                            else
                                Growth::create($this->form->getState());


                            $this->redirect(Dashboard::getUrl());

                        })
                        ->label('حفظ ومتابعة'),
                    Action::make('cancel')
                        ->action(function (){
                            $this->redirect(Dashboard::getUrl());
                        })
                        ->label('حفظ وخروج')
                ])->alignCenter(),


            ])->columns(5) ;

    }
}

