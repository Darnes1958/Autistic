<?php

namespace App\Filament\Resources;

use App\Enums\Person_relationship;
use App\Filament\Resources\AutisticResource\Pages;
use App\Filament\Resources\AutisticResource\RelationManagers;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Brother;
use App\Models\Center;
use App\Models\Disease;
use App\Models\Family;
use App\Models\Near;
use App\Models\Street;
use App\Models\Symptom;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Filament\Support\Exceptions\Halt;

class AutisticResource extends Resource
{
    use PublicTrait;

    protected static ?string $model = Autistic::class;
    protected static ?string $navigationLabel='ادخال وتعديل بيانات';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Wizard::make([
                  Wizard\Step::make('national_number')
                   ->label('الرقم الوطني')
                   ->description('يجب ادخال الرقم الوطني أولا ')
                   ->schema([
                       self::getInput('nat_id','الرقم الوطني')
                           ->live(onBlur: true)
                           ->numeric()
                            ->rules(['digits:12'])
                           ->startsWith([1,2])
                           ->afterStateUpdated(function ($state,Set $set) {
                               if ($state){
                                   $set('sex',$state[0]);
                               }
                           })

                           ->unique(ignoreRecord: true)
                           ->validationMessages([
                               'unique' => 'هذا الرقم مخزون مسبقا',
                               'digits'=>'يجب ان يتكون الرقم من 12 خانة',
                               'starts_with'=>'يجب ان يبدأ بالرقم 1 او 2'
                           ]),
                   ])->afterValidation(function (Get $get) {
                          if (intval(substr($get('nat_id'),1,4))<1980){
                              Notification::make()
                                  ->title('رقم خطأ')
                                  ->send();
                              throw new Halt();
                          }
                      })
                      ->columns(4),
                  Wizard\Step::make('other_data')
                   ->label('البيانات')
                   ->schema([
                       Grid::make()
                           ->schema([
                               Section::make('بيانات أولية')
                                  ->schema([
                                               self::getInput('name','الاسم الاول'),
                                               self::getInput('surname'),
                                               self::getRadio('sex','الجنس'),
                                               self::getDate('birthday'),
                                               self::getSelect('birth_city'),

                                               Fieldset::make('العنوان الحالي')
                                                   ->schema([
                                                       self::getSelect('city_id','المدينة')
                                                           ->afterStateUpdated(function (Set $set){
                                                               $set('street_id',null);
                                                           }),
                                                       self::getSelect('street_id','الحي')
                                                           ->options(fn (Forms\Get $get): Collection => Street::query()
                                                               ->where('city_id', $get('city_id'))
                                                               ->pluck('name', 'id'))
                                                           ->disabled(function (Forms\Get $get){return !$get('city_id'); })
                                                           ->createOptionUsing(function (array $data,Get $get) : int {
                                                               $data['city_id']=$get('city_id');
                                                               return Street::create($data)->getKey();
                                                           })
                                                       ,
                                                       self::getSelect('near_id','اقرب نقطة دالة')
                                                           ->options(fn (Forms\Get $get): Collection => Near::query()
                                                               ->where('street_id', $get('street_id'))
                                                               ->pluck('name', 'id'))
                                                           ->disabled(function (Forms\Get $get){return !$get('street_id'); })
                                                           ->createOptionUsing(function (array $data,Get $get) : int {
                                                               $data['street_id']=$get('street_id');
                                                               return Near::create($data)->getKey();
                                                           }),
                                                   ])
                                                   ->columns(3),
                                               self::getSelect('center_id')
                                                   ->label('مركز التوحد (اذا كان الطفل ملتحقا بمركز)')

                                                   ->required(false)
                                                   ->options(fn (Forms\Get $get): Collection => Center::query()
                                                       ->where('city_id', $get('city_id'))
                                                       ->pluck('name', 'id'))
                                                   ->disabled(function (Forms\Get $get){return !$get('city_id'); })
                                                   ->createOptionUsing(function (array $data,Get $get) : int {
                                                       $data['city_id']=$get('city_id');
                                                       return Center::create($data)->getKey();
                                                   }),
                                               self::getSelectEnum('academic'),
                                               Fieldset::make('الشخص الذي قام بتعبئة البيانات')
                                                   ->schema([
                                                            self::getInput('person_name')->columnSpan(3),
                                                            self::getSelectEnum('person_relationship')->columnSpan(2),
                                                       self::getInput('person_phone')->columnSpan(2),
                                                       self::getSelect('person_city')->columnSpan(2),
                                                       self::getDate('person_date')->columnSpan(2),
                                                   ])
                                                   ->columns(6)
                                                   ->columnSpanFull(),
                                               Select::make('symptom_id')
                                                   ->options(Symptom::all()->pluck('name', 'id'))
                                                   ->preload()
                                                   ->required()
                                                   ->searchable()
                                                   ->label('الاعراض')->multiple()->columnSpan(2),
                                               self::getSelectEnum('sym_year'),

                                           ])
                                   ->collapsible()
                                   ->columns(4)
                           ]),
                       Grid::make()
                           ->relationship('Family')
                           ->schema([
                               Section::make('بيانات عن الاسرة')
                                   ->schema([
                                       Fieldset::make('الأب')
                                           ->schema([
                                               self::getInput('father_name'),
                                               self::getSelect('father_city'),
                                               self::getDate('father_date'),
                                               self::getSelectEnum('father_academic')
                                                   ->columnSpan(2),
                                               self::getInput('father_job'),
                                               self::getRadio('is_father_life'),
                                               self::getInput('father_dead_reason')
                                                   ->visible(function (Get $get){return !$get('is_father_life');}),
                                               self::getDate('father_dead_date')
                                                   ->visible(function (Get $get){return !$get('is_father_life');}),
                                           ])->columns(4),
                                       Fieldset::make('الأم')
                                           ->schema([
                                               self::getInput('mother_name'),
                                               self::getSelect('mother_city'),
                                               self::getDate('mother_date'),
                                               self::getSelectEnum('mother_academic')
                                                   ->columnSpan(2),
                                               self::getInput('mother_job'),
                                               self::getRadio('is_mother_life'),
                                               self::getInput('mother_dead_reason')->columnSpan(2)
                                                   ->visible(function (Get $get){return !$get('is_mother_life');}),
                                               self::getDate('mother_dead_date')->columnSpan(2)
                                                   ->visible(function (Get $get){return !$get('is_mother_life');}),
                                               self::getInput('number_of_marriages')->numeric()->minValue(1)->default(1),
                                               self::getInput('number_of_separation')->numeric()->default(0),
                                               self::getInput('number_of_pregnancies')->numeric()->minValue(1)->default(1),
                                               self::getInput('number_of_miscarriages')->numeric()->default(0),
                                           ])->columns(4),
                                       Fieldset::make('هل تعرض أحد الوالدين لامراض مزمنة او اصابات اخري')
                                           ->schema([
                                               self::getRadio('father_chronic_diseases','الأب'),
                                               self::getRadio('mother_chronic_diseases','الام'),
                                           ])->columns(2),
                                       self::getRadio('is_parent_relationship'),
                                       self::getSelect('father_blood_type','فصيلة دم الأب'),
                                       self::getSelect('mother_blood_type','فصيلة دم الأم'),
                                       self::getSelectEnum('parent_relationship_nature'),
                                       Section::make()
                                           ->schema([
                                               TableRepeater::make('Brother')
                                                   ->columnSpanFull()
                                                   ->label('بيانات الاخوة')
                                                   ->relationship()
                                                   ->headers([
                                                       Header::make('الاسم')
                                                           ->width('12%'),
                                                       Header::make('ت.الولادة')
                                                           ->width('14%'),
                                                       Header::make('الجنس')
                                                           ->width('12%'),
                                                       Header::make('الحالة الصحية')
                                                           ->width('12%'),
                                                       Header::make('السبب تدهور الصحة')
                                                           ->width('12%'),
                                                       Header::make('المستوي التعليمي')
                                                           ->width('12%'),
                                                       Header::make('المهنة')
                                                           ->width('12%'),
                                                       Header::make('اتجاه وعلاقته بالطفل')
                                                           ->width('12%'),
                                                   ])
                                                   ->streamlined()
                                                   ->live()
                                                   ->defaultItems(0)
                                                   ->addActionLabel('إضافة أخ / أخت')
                                                   ->schema([
                                                       self::getInput('name',' '),
                                                       self::getDate('brother_date',' '),
                                                       self::getRadio('brother_sex',' '),
                                                       self::getRadio('brother_health',' '),
                                                       self::getInput('brother_health_reason',' ')->required(false),
                                                       self::getSelectEnum('brother_academic',' '),
                                                       self::getInput('brother_job',' ')->required(false),
                                                       self::getSelectEnum('brother_relation',' ')->required(false),
                                                   ])
                                                   ->addable(function ($state){
                                                       $flag=true;
                                                       foreach ($state as $item) {
                                                           if (!$item['name'] || !$item['brother_date'] ) {$flag=false; break;}
                                                       }
                                                       return $flag;
                                                   }),

                                           ]),

                                       self::getDiseaseSelect(),
                                       self::getSelectEnum('family_salary'),
                                       self::getSelectEnum('family_sources'),
                                       self::getRadio('house_type'),
                                       self::getRadio('house_narrow'),
                                       self::getRadio('house_health'),
                                       self::getRadio('house_old'),
                                       self::getRadio('house_own'),
                                       self::getRadio('is_house_good'),
                                       self::getInput('house_rooms','عدد الحجرات')->numeric()->minValue(1),
                                       self::getRadio('is_room_single'),
                                       Forms\Components\Textarea::make('other_family_notes')
                                           ->label('معلومات أخري')->columnSpanFull(),
                                   ])
                                   ->collapsible()
                                   ->columns(4),
                           ]),
                       Grid::make()
                           ->relationship('Boy')
                           ->schema([
                               Section::make('بيانات عن الطفل وتوقعات الأسرة ')
                                   ->schema([
                                       self::getInput('as_father_say','كما ورد علي لسان الأب'),
                                       self::getInput('as_mother_say','كما ورد علي لسان الأم'),
                                       self::getRadio('how_past')->live(),
                                       self::getInput('past_problem','الصعوبات التي ظهرت ')->required(false)
                                           ->visible(function (Get $get){return $get('how_past')==0;}),
                                       Fieldset::make('مدي تأثير الإضطرابات علي الطفل')
                                           ->schema([
                                               self::getSelectEnum('with_people'),
                                               self::getSelectEnum('with_motion'),
                                               self::getSelectEnum('with_language'),
                                               self::getSelectEnum('with_personal'),
                                               self::getSelectEnum('with_mind'),
                                           ])->columns(3),
                                       self::getSelect('ambitious_id'),
                                       self::getInput('other_boy_info','معلومات اخري عن الطفل')->required(false)->columnSpan(3),

                                       Fieldset::make('ما أساليب التعامل مع الطفل')
                                           ->schema([
                                               self::getSelectEnum('father_procedure'),
                                               self::getSelectEnum('mother_procedure'),
                                               self::getSelectEnum('brother_procedure'),
                                               self::getSelectEnum('boy_response'),
                                           ])->columns(4)->columnSpan(4),


                                   ])
                                   ->columns(4)
                                   ->collapsible()
                           ]),
                       Grid::make()
                           ->relationship('Growth')
                           ->schema([
                               Section::make('بيانات عن تاريخ النمو')
                                   ->schema([
                                       self::getInput('mother_old','عمر الأم عند ولادة الطفل')
                                           ->numeric()
                                           ->live(onBlur: true)
                                           ->afterStateUpdated(function (Set $set, $state){
                                               if ($state>55 || $state<16) {
                                                   $set('mother_old', null);
                                                   self::noti_danger('يجب أن يكون عمر الام عند الولادة من 16 الي 55');
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
                                       self::getRadio('is_pregnancy_planned','هل كان الحمل مخططا له'),
                                       self::getRadio('mother_p_d_health')->live(),
                                       self::getInput('p_d_why_not_health','لماذا كانت غير جيدة')
                                           ->visible(fn(Get $get): bool =>$get('mother_p_d_health')==0)->nullable(),
                                       self::getRadio('is_p_d_followed','هل تم الحمل بمتابعة طبية'),
                                       self::getRadio('is_p_d_good_food','هل غذاء الام اثناء الحمل جيد'),
                                       self::getRadio('is_child_wanted','هل كان الطفل مرغوب فيه'),
                                       self::getRadio('is_p_d_disease','هل تعرضت الام لأي أمراض أو حوادث')->default(0)->live(),
                                       self::getInput('p_d_disease',' ماهي الامراض او الحوادث')
                                           ->nullable()->visible(fn(Get $get): bool =>$get('is_p_d_disease')==1)->nullable(),
                                       Grid::make()
                                           ->schema([
                                               self::getSelectEnum('is_pregnancy_normal'),
                                               self::getSelectEnum('where_pregnancy_done'),
                                               self::getSelectEnum('pregnancy_time'),
                                               self::getSelectEnum('child_weight'),
                                               self::getRadio('is_child_followed','هل احتاج الطفل بعد ولادته إلي رعاية خاصة')->live(),
                                               self::getinput('why_child_followed','لماذا احتاج لرعاية')
                                                   ->visible(fn(Get $get):bool =>$get('is_child_followed'))->nullable(),
                                           ])
                                           ->columns(3),
                                       Section::make()
                                           ->schema([
                                               TableRepeater::make('BoyDisease')
                                                   ->columnSpanFull()
                                                   ->label('قائمة بأبرز الأمراض التي أصيب بها الطفل')
                                                   ->relationship()
                                                   ->headers([
                                                       Header::make('المرض')
                                                           ->width('30%'),
                                                       Header::make('عمر الطفل عند الإصابة')
                                                           ->width('10%'),
                                                       Header::make('مدة المرض')
                                                           ->width('10%'),
                                                       Header::make('شدته')
                                                           ->width('10%'),
                                                       Header::make('العلاج')
                                                           ->width('20%'),

                                                   ])
                                                   ->live()
                                                   ->defaultItems(0)
                                                   ->addActionLabel('إضافة مرض')
                                                   ->schema([
                                                       self::getSelect('disease_menu_id',' '),
                                                       self::getInput('age',' '),
                                                       self::getInput('period',' '),
                                                       self::getInput('intensity',' '),
                                                       self::getInput('treatment',' '),
                                                   ])
                                                   ->addable(function ($state){
                                                       $flag=true;
                                                       foreach ($state as $item) {
                                                           if (!$item['disease_menu_id'] || !$item['age']  || !$item['period']
                                                               || !$item['intensity'] || !$item['treatment']) {$flag=false; break;}
                                                       }
                                                       return $flag;
                                                   }),

                                           ]),
                                       self::getRadio('is_breastfeeding_natural'),
                                       self::getSelectEnum('breastfeeding_period'),
                                       self::getRadio('difficulties_during_weaning','هل حدثت صعوبات اثناء الفطام'),
                                       self::getSelectEnum('when_can_set'),
                                       self::getSelectEnum('teeth_appear'),
                                       self::getSelectEnum('could_crawl'),
                                       self::getSelectEnum('could_stand'),
                                       self::getSelectEnum('could_walk'),
                                       self::getSelectEnum('when_try_speak'),
                                       self::getSelectEnum('when_speak'),
                                       self::getSelectEnum('when_open_door'),
                                       self::getSelectEnum('when_set_export'),
                                       self::getSelectEnum('when_wear_shoes'),
                                       self::getSelectEnum('when_use_spoon'),
                                       self::getRadio('is_child_food_good'),
                                       self::getRadio('sleep_habit'),
                                       self::getRadio('is_disturbing_nightmares','هل يتعرض لكوابيس مزعجة'),
                                       self::getRadio('safety_of_senses','هل الحواس سليمة'),
                                       self::getinput('who_senses','ماهي الحواس المصابة')
                                           ->visible(fn(Get $get):bool => !$get('safety_of_senses'))->nullable(),
                                       self::getRadio('mental_health','هل الوظائف العقلية سليمة'),
                                       self::getInput('who_mental','ماهي الوظائف المصابة')
                                           ->visible(fn(Get $get):bool => !$get('mental_health'))->nullable(),
                                       self::getRadio('injuries_disabilities','هل توجد إصابات أو عاهات جسيمة'),
                                       Section::make()
                                           ->schema([
                                               TableRepeater::make('GrowDifficult')
                                                   ->columnSpanFull()
                                                   ->label('صعوبات النمو التي تعرض لها الطفل')
                                                   ->relationship()
                                                   ->headers([
                                                       Header::make('الصعوبة')
                                                           ->width('30%'),
                                                       Header::make('العمر')
                                                           ->width('10%'),
                                                       Header::make('الاجراءات التي اتخذت')
                                                           ->width('60%'),

                                                   ])
                                                   ->live()
                                                   ->defaultItems(0)
                                                   ->addActionLabel('إضافة صعوبة')
                                                   ->schema([
                                                       self::getSelect('grow_difficult_menu_id',' '),
                                                       self::getInput('age',' '),
                                                       self::getInput('procedures',' '),

                                                   ])
                                                   ->addable(function ($state){
                                                       $flag=true;
                                                       foreach ($state as $item) {
                                                           if (!$item['grow_difficult_menu_id'] || !$item['age']  || !$item['procedures']) {$flag=false; break;}
                                                       }
                                                       return $flag;
                                                   }),

                                           ]),
                                       self::getRadio('is_take_medicine','هل يتناول الطفل دواء'),
                                       TableRepeater::make('GrowMedicine')
                                           ->label('قائمة بالادوية التي يتناولها ')
                                           ->relationship()
                                           ->headers([
                                               Header::make('اسم الدواء')
                                                   ->width('100%'),
                                           ])
                                           ->live()
                                           ->defaultItems(0)
                                           ->addActionLabel('إضافة دواء')
                                           ->schema([
                                               self::getSelect('medicine_id',' '),
                                           ])
                                           ->addable(function ($state){
                                               $flag=true;
                                               foreach ($state as $item) {
                                                   if (!$item['medicine_id'] ) {$flag=false; break;}
                                               }
                                               return $flag;
                                           }),
                                       FileUpload::make('prescription_image')
                                           ->directory('prescription-images')
                                           ->label('صورة وصفة الدواء'),
                                       self::getRadio('is_child_play_toy','هل يمارس الطفل اللعب بالالعاب'),
                                       self::getInput('why_not_play_toy','لماذا لا يمارس اللعب بالالعاب ؟')
                                           ->visible(fn(Get $get):bool => !$get('is_child_play_toy'))->nullable(),
                                       self::getSelectEnum('is_play_with_other')->multiple(),
                                       self::getRadio('slookea_1','هل طفلك يستمتع بان يتأرجح ويتمايل'),
                                       self::getRadio('slookea_2','هل طفلك مهتم بالأخرين'),
                                       self::getRadio('slookea_3','هل طفلك يتسلق الاشياء مثل السلالم وما شابه'),
                                       self::getRadio('slookea_4','هل طفلك يمارس العاب الطفال مثل لعبة الاستغماية (التخفي)'),
                                       self::getRadio('slookea_5','هل يمارس طفلك (اللعب التخيلي) مثلاً انه يقوم بعمل الشاي باستخدام اكواب وأدوات من اللعب او غيرها '),
                                       self::getRadio('slookea_6','هل يستخدم طفلك اصبعه ليشير الي أشياء يريد أن يسألك عنها'),
                                       self::getRadio('slookea_7','هل يستخدم طفلك اصبعه ليشير الي أشياء هو مهتم بها'),
                                       self::getRadio('slookea_8','هل يحضر لك طفلك اشياء لكي يريها لك'),

                                       self::getRadio('slookea_9','هل يقوم الطفل بالدوران حول نفسه'),
                                       self::getRadio('slookea_10','هل يسير علي أطراف الاصابع'),

                                       self::getInput('slookea_other','مظاهر سلوكية اخري'),


                                   ])
                                   ->collapsible()
                                   ->columns(4),
                           ]),
                   ]),
              ])->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                self::getColumn('full_name'),
                self::getColumn('City.name'),
                Tables\Columns\TextColumn::make('symptom_id')
                    ->label('الاعراض والصعوبات')
                    ->formatStateUsing(function ($state, $record) {
                        return join(" , ",Symptom::whereIn('id',$record->symptom_id)->pluck('name')->toarray());
                    })
                    ->html(),
                self::getColumn('person_name')
                 ->description(function ($record){
                     return Person_relationship::tryFrom($record->person_relationship)->name;
                 })
            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('del')
                    ->icon('heroicon-o-trash')
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record){
                        $record->delete();
                    }),
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
            'index' => Pages\ListAutistics::route('/'),
            'create' => Pages\CreateAutistic::route('/create'),
            'edit' => Pages\EditAutistic::route('/{record}/edit'),
        ];
    }

}
