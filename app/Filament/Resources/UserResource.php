<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;

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
                                                  ->label('محل الملاد'),
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
                                                    ->label('محل الملاد'),
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
                                            ])->columns(3),



                                    ])
                                    ->columns(5),
                            ])
                    )
                    ->label('بيانات عن الأسرة'),
                Tables\Columns\IconColumn::make('has_boy')
                    ->boolean()
                    ->label('بيانات عن الحالة'),
                Tables\Columns\IconColumn::make('has_grow')
                    ->boolean()
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
