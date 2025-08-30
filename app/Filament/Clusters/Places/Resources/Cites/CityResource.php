<?php

namespace App\Filament\Clusters\Places\Resources\Cites;

use App\Filament\Clusters\Places;
use App\Filament\Clusters\Places\Resources\Cites\Pages\CreateCity;
use App\Filament\Clusters\Places\Resources\Cites\Pages\EditCity;
use App\Filament\Clusters\Places\Resources\Cites\Pages\ListCities;

use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Center;
use App\Models\City;
use App\Models\Street;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CityResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = City::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster=Places::class;
    protected static ?string $navigationLabel='مدن';
    protected static ?string $pluralLabel='مدن';
    protected static ?int $navigationSort=1;


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(function (Model $record){
                        return !Autistic::where('city_id',$record->id)->exists()
                            && !Street::where('city_id',$record->id)->exists()
                            && !Center::where('city_id',$record->id)->exists();
                    }),

            ])
            ->toolbarActions([
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
            'index' => ListCities::route('/'),
            'create' => CreateCity::route('/create'),
            'edit' => EditCity::route('/{record}/edit'),
        ];
    }
}
