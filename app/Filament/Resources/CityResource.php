<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Places;
use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Center;
use App\Models\City;
use App\Models\Street;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CityResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster=Places::class;
    protected static ?string $navigationLabel='مدن';
    protected static ?string $pluralLabel='مدن';
    protected static ?int $navigationSort=1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::getInput('name','اسم المدينة')->unique(ignoreRecord: true)->inlineLabel(false),
                Hidden::make('user_id')->default(Auth::id())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                self::getColumn('name'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Model $record){
                        return !Autistic::where('city_id',$record->id)->exists()
                            && !Street::where('city_id',$record->id)->exists()
                            && !Center::where('city_id',$record->id)->exists();
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
