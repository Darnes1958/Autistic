<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;

use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='ادخال وتعديل وعرض الحالات';


 public static function canAccess(): bool
 {
     return auth()->user()->is_admin;
 }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nat')->label('الرقم الوطني')
                    ->live()
                    ->afterStateUpdated(function ($state,Forms\Set $set) {
                        $set('password', $state);
                    })
                    ->unique(ignoreRecord: true)->required(),
                TextInput::make('name')->label('الاسم')->unique(ignoreRecord: true)->required(),
                TextInput::make('password')->required()->visibleOn('create'),
                Forms\Components\Hidden::make('is_admin')->default(0),
                Forms\Components\Hidden::make('is_employee')->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {

                    return $query
                        ->where('is_employee', 0)

                        ;

            })
            ->recordUrl(
                false
            )
            ->columns([
                TextColumn::make('nat')->label('الرقم الوطني'),
                TextColumn::make('name')->label('الاسم'),
                Tables\Columns\IconColumn::make('has_aut')
                    ->boolean()
                    ->action(
                        Tables\Actions\Action::make('aut_info')
                            ->visible(function ($record){return $record->has_aut;})
                            ->label('البيانات الأولية')
                            ->modalSubmitAction(false)
                            ->modalCancelAction(fn (StaticAction $action) => $action->label('عودة'))

                            ->infolist([
                            Section::make()
                             ->schema([
                               TextEntry::make('Autistic.name')

                                   ->label('الإسم'),
                               TextEntry::make('Autistic.surname')
                                   ->label('إسم الأب'),
                               TextEntry::make('Autistic.sex')
                                   ->label('النوع'),
                               TextEntry::make('Autistic.birthday')
                                   ->label('تاريخ الميلاد'),
                               TextEntry::make('Autistic.BirthCity.name')
                                   ->label('مكان الميلاد'),
                                 Fieldset::make('العنوان')
                                    ->schema([
                                        TextEntry::make('Autistic.City.name')
                                            ->label('المدينه'),
                                        TextEntry::make('Autistic.Street.name')
                                            ->label('الشارع'),
                                        TextEntry::make('Autistic.Near.name')
                                            ->label('اقرب نقطة دالة')

                                    ])->columns(3),

                                 Fieldset::make('الشخص الذي قام بتعبئة البيانات')
                                     ->schema([
                                         TextEntry::make('Autistic.person_name')->label('الاسم'),
                                         TextEntry::make('Autistic.person_relationship')->label('علاقته بالحالة'),
                                         TextEntry::make('Autistic.person_phone')->label('هاتف'),
                                         TextEntry::make('Autistic.PersonCity.name')->label('العنوان'),
                                         TextEntry::make('Autistic.person_date')->label('تاريخ التعبئة'),
                                     ])
                                     ->columns(5),
                                 TextEntry::make('Autistic.Center.name')
                                     ->label('مركز التوحد'),
                                 TextEntry::make('Autistic.symptoms')
                                     ->label('الأعراض التي تمت ملاحظاتها'),
                                 TextEntry::make('Autistic.sym_year')
                                     ->label('تمت رؤية الأعراض في العام'),

                             ])
                            ->columns(5),
                        ])
                    )
                    ->label('بيانات أولية'),
                Tables\Columns\IconColumn::make('has_fam')
                    ->boolean()
                    ->action(
                        Tables\Actions\Action::make('fam_info')
                            ->visible(function ($record){return $record->has_fam;})
                            ->label('بيانات عن الأسرة')
                            ->modalSubmitAction(false)
                            ->modalCancelAction(fn (StaticAction $action) => $action->label('عودة'))
                            ->infolist([
                                Section::make()
                                    ->schema([
                                        Fieldset::make('الأب')
                                          ->schema([
                                              TextEntry::make('Family.father_name')
                                                  ->label('الإسم'),
                                              TextEntry::make('Family.FatherCity.name')
                                                  ->label('محل الميلاد'),
                                              TextEntry::make('Family.father_date')
                                                  ->label('تاريخ الميلاد'),
                                              TextEntry::make('Family.father_academic')
                                                  ->label('المستوي الدراسي'),
                                              TextEntry::make('Family.father_job')
                                                  ->label('المهنة'),
                                              TextEntry::make('Family.is_father_life')
                                                  ->label('هل الأب علي قيد الحياة ؟'),
                                              TextEntry::make('Family.father_dead_reason')
                                                  ->visible(function ($record){return $record->Family->is_father_life->value==0;})
                                                  ->label('سبب وفاة الأب'),
                                              TextEntry::make('Family.father_dead_date')
                                                  ->visible(fn($record) :bool => $record->Family->is_father_life->value==0)
                                                  ->label('تاريخ وفاة الأب'),

                                          ])->columns(3),
                                        Fieldset::make('الأم')
                                            ->schema([
                                                TextEntry::make('Family.mother_name')
                                                    ->label('الإسم'),
                                                TextEntry::make('Family.MotherCity.name')
                                                    ->label('محل الميلاد'),
                                                TextEntry::make('Family.mother_date')
                                                    ->label('تاريخ الميلاد'),
                                                TextEntry::make('Family.mother_academic')
                                                    ->label('المستوي الدراسي'),
                                                TextEntry::make('Family.mother_job')
                                                    ->label('المهنة'),
                                                TextEntry::make('Family.is_mother_life')
                                                    ->label('هل الأم علي قيد الحياة ؟'),
                                                TextEntry::make('Family.mother_dead_reason')
                                                    ->columnStart(2)
                                                    ->visible(function ($record){return $record->Family->is_mother_life->value==0;})
                                                    ->label('سبب وفاة الأم'),
                                                TextEntry::make('Family.mother_dead_date')
                                                    ->visible(fn($record) :bool => $record->Family->is_mother_life->value==0)
                                                    ->label('تاريخ وفاة الأم'),
                                                TextEntry::make('Family.number_of_marriages')
                                                 ->label('عدد مرات الزواج'),
                                                TextEntry::make('Family.number_of_separation')
                                                    ->label('عدد مرات الانفصال'),
                                                TextEntry::make('Family.number_of_pregnancies')
                                                    ->label('عدد مرات الحمل'),
                                                TextEntry::make('Family.number_of_miscarriages')
                                                    ->label('عدد مرات الاجهاض'),
                                                TextEntry::make('Family.father_chronic_diseases')
                                                    ->visible(fn($record) :bool => $record->Family->is_father_chronic_diseases)
                                                    ->label('أمراض الأب المزمنة'),
                                                TextEntry::make('Family.mother_chronic_diseases')
                                                    ->visible(fn($record) :bool => $record->Family->is_mother_chronic_diseases)
                                                    ->label('أمراض الأم المزمنة'),
                                                TextEntry::make('Family.is_parent_relationship')
                                                    ->label('هل هناك صلة قرابة بين الاب والام ? '),
                                                TextEntry::make('Family.FatherBlood.name')
                                                    ->label('فصيلة دم الأب'),
                                                TextEntry::make('Family.MotherBlood.name')
                                                    ->label('فصيلة دم الأم'),
                                                TextEntry::make('Family.parent_relationship_nature')
                                                    ->label('ما هي طبيعة العلاقة بين الأب والأم '),
                                                TextEntry::make('Family.brothers_count')
                                                    ->label('عدد الإخوة والأخوات'),
                                                TextEntry::make('Family.male_count')
                                                    ->label('عدد الذكور'),
                                                TextEntry::make('Family.female_count')
                                                    ->label('عدد الإناث'),
                                                TextEntry::make('Family.ser_in_brothers')
                                                    ->label('تسلل الحالة في الأسرة'),
                                                TextEntry::make('Family.mother_chronic_diseases')
                                                    ->visible(fn($record) :bool => $record->Family->family_disease !=null)
                                                    ->label('أمراض أصيب بها بعض من افراد'),
                                                TextEntry::make('Family.mother_chronic_diseases')
                                                    ->visible(fn($record) :bool => $record->Family->other_diseases !=null)
                                                    ->label('أمراض اخري أصيب بها بعض من افراد'),

                                                TextEntry::make('Family.family_salary')
                                                    ->label('الدخل الشهري'),
                                                TextEntry::make('Family.family_sources')
                                                    ->label('مصادر دخل الأسرة'),
                                                TextEntry::make('Family.house_type')
                                                    ->label('نوع السكن'),
                                                TextEntry::make('Family.house_narrow')
                                                    ->label('مساحة السكن'),
                                                TextEntry::make('Family.house_health')
                                                    ->label('الحالة الصحية للسكن'),
                                                TextEntry::make('Family.house_old')
                                                    ->label('حالة السكن'),
                                                TextEntry::make('Family.house_own')
                                                    ->label('ملكية السكن'),
                                                TextEntry::make('Family.is_house_good')
                                                    ->label('متطلبات الحياة الأساسية'),
                                                TextEntry::make('Family.house_rooms')
                                                    ->label('عدد الحجرات'),
                                                TextEntry::make('Family.is_room_single')
                                                    ->label('هل حجرة الحالة فردية'),
                                                TextEntry::make('Family.has_salary')
                                                    ->label('هل يتقاضي الحالة معاش اساسي'),
                                                TextEntry::make('Family.why_not_has_salary')
                                                    ->visible(fn($record) :bool => $record->Family->has_salary =0)
                                                    ->label('اسباب عدم تقاضي المعاش'),
                                                TextEntry::make('Family.other_family_notes')
                                                    ->label('مغلومات أخري'),



                                            ])->columns(3),



                                    ])
                                    ->columns(5),
                            ])
                    )
                    ->label('بيانات عن الأسرة'),
                Tables\Columns\IconColumn::make('has_boy')
                    ->boolean()
                    ->action(
                        Tables\Actions\Action::make('boy_info')
                            ->visible(function ($record){return $record->has_boy;})
                            ->label(fn()=>self::ret_html('بيانات عن الحالة'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(fn (StaticAction $action) => $action->label('عودة'))
                            ->infolist([
                                    Section::make()
                                        ->schema([
                                            self::getEntry('Boy.how_past','وضع الحالة في بداية ظهور الاعراض')
                                                ->listWithLineBreaks()
                                                ->bulleted(),
                                             self::getEntry('Boy.other_past','اعراض أحري')
                                                ->visible(fn($record) => $record->other_past!=null),
                                            self::getEntry('Boy.Ambitious.name','ما هو طموح الأسرة بالنسبة للطفل'),
                                            self::getEntry('Boy.other_boy_info','معلومات اخري عن الحالة'),
                                            Fieldset::make('any')
                                                ->label(fn()=>self::ret_html('أساليب التعامل مع الحالة'))
                                                ->schema([
                                                    TextEntry::make('Boy.father_procedure')
                                                        ->label('الأب'),
                                                    TextEntry::make('Boy.mother_procedure')
                                                        ->label('الأم'),
                                                    TextEntry::make('Boy.brother_procedure')
                                                        ->label('الإخوة'),

                                                ]),


                                        ])

                                ])
                    )
                    ->label('بيانات عن الحالة'),
                Tables\Columns\IconColumn::make('has_grow')
                    ->boolean()
                    ->action(
                        Tables\Actions\Action::make('grow_info')
                            ->visible(function ($record){return $record->has_grow;})
                            ->label(fn()=>self::ret_html('تاريخ النمو'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(fn (StaticAction $action) => $action->label('عودة'))
                            ->infolist([
                                Section::make()
                                    ->schema([
                                        self::getEntry('Growth.mother_old','عمر الأم عند ولادة الحالة'),
                                        self::getEntry('Growth.pregnancy_duration','مدة الحمل'),
                                        self::getEntry('Growth.is_pregnancy_planned','هل كان الحمل مخططا له'),
                                        self::getEntry('Growth.mother_p_d_health','حالة الام الصحية اثناء الحمل'),
                                        self::getEntry('Growth.p_d_why_not_health','لماذا كانت غير جيدة')
                                            ->visible(fn($record): bool => $record->Growth->mother_p_d_health==0),

                                        self::getEntry('Growth.is_p_d_followed','هل تم الحمل بمتابعة طبية'),
                                        self::getEntry('Growth.is_p_d_good_food','هل غذاء الام اثناء الحمل جيد'),
                                        self::getEntry('Growth.is_child_wanted','هل كان الحالة مرغوب فيه'),
                                        self::getEntry('Growth.is_p_d_disease','هل تعرضت الام لأي أمراض أو حوادث'),

                                        self::getEntry('Growth.p_d_disease',' ماهي الامراض او الحوادث')
                                            ->visible(fn($record): bool => $record->Growth->is_p_d_disease==1),

                                        Fieldset::make(' ')
                                            ->label(fn()=>self::ret_html('معلومات عن الحمل','my-yellow text-lg'))
                                            ->schema([
                                                self::getEntry('Growth.is_pregnancy_normal','هل كانت الولادة طبيعية'),
                                                self::getEntry('Growth.where_pregnancy_done','اين تمت عملية الولادة'),
                                                self::getEntry('Growth.pregnancy_time','ما الوقت الذي استغرقته عملية الولادة'),
                                                self::getEntry('Growth.child_weight','وزن الحالة اثناء الولادة'),
                                                self::getEntry('Growth.is_child_followed','هل احتاج الحالة بعد ولادته إلي رعاية خاصة'),

                                                self::getEntry('Growth.why_child_followed','لماذا احتاج لرعاية')
                                                    ->visible(fn($record):bool =>  $record->Growth->is_child_followed==1),

                                            ])->columns(5),


                                        self::getEntry('Growth.is_breastfeeding_natural','هل كانت الرضاعة طبيعية '),
                                        self::getEntry('Growth.breastfeeding_period','مدة الرضاعة'),
                                        self::getEntry('Growth.difficulties_during_weaning','هل حدثت صعوبات اثناء الفطام'),


                                        self::getEntry('Growth.what_is_the_defficulties','ما هي الصعوبات ؟')
                                            ->visible(fn($record):bool => $record->Growth->difficulties_during_weaning==1),

                                        self::getEntry('Growth.when_can_set','متى استطاع الجلوس'),
                                        self::getEntry('Growth.teeth_appear','متى بدأت الاسنان بالظهور'),
                                        self::getEntry('Growth.could_crawl','متى استطاع الحبو (الزحف)'),
                                        self::getEntry('Growth.could_stand','متى استطاع الوقوف'),
                                        self::getEntry('Growth.could_walk','متى استطاع المشي'),
                                        self::getEntry('Growth.when_try_speak','متى بدأت محاولة النطق'),
                                        self::getEntry('Growth.when_speak','متى استطاع التحدث'),
                                        self::getEntry('Growth.when_open_door','متى استطاع فتح الابواب'),
                                        self::getEntry('Growth.when_set_export','متى ضبط عمليات الاخراج'),
                                        self::getEntry('Growth.when_wear_shoes','متى استطاع ان يلبس الحذاء'),
                                        self::getEntry('Growth.when_use_spoon','متى استطاع استخدام الملعقة و الكوب'),
                                        self::getEntry('Growth.is_child_food_good','كيف كانت تغذية الحالة '),

                                        self::getEntry('Growth.why_food_not_good','اسباب التغذية الغير جيدة')
                                            ->visible(fn($record):bool => $record->Growth->is_child_food_good==0),

                                        self::getEntry('Growth.sleep_habit','ما عادات الحالة في النوم '),
                                        self::getEntry('Growth.is_disturbing_nightmares','هل يتعرض لكوابيس مزعجة'),
                                        self::getEntry('Growth.safety_of_senses','هل الحواس سليمة'),

                                        self::getEntry('Growth.who_senses','ماهي الحواس المصابة')
                                            ->visible(fn($record):bool => $record->Growth->safety_of_senses==0),
                                        self::getEntry('Growth.mental_health','هل الوظائف العقلية سليمة'),

                                        self::getEntry('Growth.who_mental','ماهي الوظائف المصابة')
                                            ->visible(fn($record):bool =>$record->Growth->mental_health==0),
                                        self::getEntry('Growth.injuries_disabilities','هل توجد إصابات أو عاهات جسيمة'),
                                        self::getEntry('Growth.is_child_play_toy','هل يمارس الحالة اللعب بالالعاب'),
                                        self::getEntry('Growth.why_not_play_toy','لماذا لا يمارس اللعب بالالعاب ؟')
                                            ->visible(fn($record):bool => $record->Growth->is_child_play_toy==0),
                                        self::getEntry('Growth.is_play_with_other','هل يلعب'),
                                        self::getEntry('Growth.slookea_1','هل الحالة يستمتع بان يتأرجح ويتمايل'),
                                        self::getEntry('Growth.slookea_2','هل الحالة مهتم بالأخرين'),
                                        self::getEntry('Growth.slookea_3','هل الحالة يتسلق الاشياء مثل السلالم وما شابه'),
                                        self::getEntry('Growth.slookea_4','هل حالةك يمارس العاب الطفال مثل لعبة الاستغماية (التخفي)'),
                                        self::getEntry('Growth.slookea_5','هل يمارس الحالة (اللعب التخيلي) مثلاً انه يقوم بعمل الشاي باستخدام اكواب وأدوات من اللعب او غيرها '),
                                        self::getEntry('Growth.slookea_6','هل يستخدم الحالة اصبعه ليشير الي أشياء يريد أن يسألك عنها'),
                                        self::getEntry('Growth.slookea_7','هل يستخدم الحالة اصبعه ليشير الي أشياء هو مهتم بها'),
                                        self::getEntry('Growth.slookea_8','هل يحضر لك الحال اشياء لكي يريها لك'),

                                        self::getEntry('Growth.slookea_9','هل يقوم الحالة بالدوران حول نفسه'),
                                        self::getEntry('Growth.slookea_10','هل يسير علي أطراف الاصابع'),

                                        self::getEntry('Growth.slookea_other','مظاهر سلوكية اخري'),

                                        Fieldset::make(' ')
                                            ->label(fn()=>self::ret_html(' أذكر أبرز الأعراض الظاهرة على الحالة','my-yellow font-extrabold '))
                                            ->schema([
                                                self::getEntry('Growth.social_communication','صعوبات في التواصل الاجتماعي')
                                                    ->listWithLineBreaks()
                                                    ->bulleted(),
                                                self::getEntry('Growth.behaviors','سلوكيات نمطية ومتكررة')
                                                    ->listWithLineBreaks()
                                                    ->bulleted(),
                                                self::getEntry('Growth.sensory','مشكلات حسية')
                                                    ->listWithLineBreaks()
                                                    ->bulleted(),
                                                self::getEntry('Growth.behavioral_and_emotional','مشكلات سلوكية وعاطفية')
                                                    ->listWithLineBreaks()
                                                    ->bulleted(),
                                            ])->columns(1),

                                    ])
                                    ->columns(4)
                            ])
                    )


                    ->label('تاريخ النمو'),
                Tables\Columns\IconColumn::make('has_med')
                    ->boolean()
                    ->label('التدخلات العلاجية'),
                Tables\Columns\ImageColumn::make('Autistic.image')
                    ->circular()
                 ->label(' ')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
