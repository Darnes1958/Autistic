<?php

namespace App\Filament\Resources;

use App\Enums\Person_relationship;
use App\Filament\Resources\AutisticResource\Pages;
use App\Filament\Resources\AutisticResource\RelationManagers;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Center;
use App\Models\Disease;
use App\Models\Near;
use App\Models\Street;
use App\Models\Symptom;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AutisticResource extends Resource
{
    use PublicTrait;
    protected static $city_id;
    protected static ?string $model = Autistic::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
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
                         self::getInput('nat_id','الرقم الوطني')
                             ->unique(ignoreRecord: true),
                         Fieldset::make('العنوان الحالي')
                             ->schema([
                                 self::getSelect('city_id','المدينة')
                                     ->afterStateUpdated(function (Forms\Set $set){
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
                         self::getRadio('academic')->columnSpan(3),
                         Fieldset::make('الشخص الذي قام بالتعبئة')
                            ->schema([
                                self::getInput('person_name')->columnSpan(2),
                                self::getSelectEnum('person_relationship'),
                                self::getInput('person_phone'),
                                self::getSelect('person_city'),
                                self::getDate('person_date'),
                            ])->columns(6),
                         Select::make('symptom_id')
                             ->options(Symptom::all()->pluck('name', 'id'))
                             ->preload()
                             ->required()
                             ->searchable()
                             ->label('الاعراض')->multiple()->columnSpan(2),
                         self::getSelectEnum('sym_year'),

                     ])->columns(4)
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
                                    self::getRadio('father_academic')
                                        ->columnSpan(2),
                                    self::getInput('father_jop'),
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
                                     self::getRadio('mother_academic')
                                         ->columnSpan(2),
                                     self::getInput('mother_jop'),
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

                         ])->columns(4),
                       Fieldset::make('هل تعرض أحد الوالدين لامراض مزمنة او اصابات اخري')
                        ->schema([
                            self::getInput('father_chronic_diseases','الاب'),
                            self::getInput('mother_chronic_diseases','الأم'),
                        ])->columns(2),
                     self::getRadio('is_parent_relationship'),
                     self::getInput('father_blood_type','فصيلة دم الأب'),
                     self::getInput('mother_blood_type','فصيلة دم الأم'),
                     self::getRadio('parent_relationship_nature')->columnSpanFull(),
                     Section::make()
                      ->schema([
                          TableRepeater::make('Brother')
                              ->columnSpanFull()
                              ->label('بيانات الاخوة')
                              ->required()
                              ->relationship()
                              ->headers([
                                  Header::make('الاسم')
                                      ->width('30%'),
                                  Header::make('ت.الولادة')
                                      ->width('10%'),
                                  Header::make('الجنس')
                                      ->width('10%'),
                                  Header::make('الحالة الصحية')
                                      ->width('10%'),
                                  Header::make('السبب تدهور الصحة')
                                      ->width('10%'),
                                  Header::make('المستوي التعليمي')
                                      ->width('10%'),
                                  Header::make('المهنة')
                                      ->width('10%'),
                                  Header::make('اتجاه وعلاقته بالطفل')
                                      ->width('10%'),
                              ])
                              ->schema([
                                  self::getInput('name',' '),
                                  self::getDate('brother_date',' '),
                                  self::getRadio('brother_sex',' '),
                                  self::getRadio('brother_health',' '),
                                  self::getInput('brother_health_reason',' '),
                                  self::getSelectEnum('brother_academic',' '),
                                  self::getInput('brother_jop',' '),
                                  self::getInput('brother_relation',' '),
                              ]),

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
                    ])->columns(4),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
