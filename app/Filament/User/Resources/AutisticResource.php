<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\AutisticResource\Pages;
use App\Filament\User\Resources\AutisticResource\RelationManagers;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Center;
use App\Models\Near;
use App\Models\Street;
use App\Models\Symptom;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Exceptions\Halt;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class AutisticResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = Autistic::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

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




                                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
