<?php

namespace App\Filament\Clusters\Places\Resources\Streets;

use App\Filament\Clusters\Places;
use App\Filament\Clusters\Places\Resources\Streets\Pages\CreateStreet;
use App\Filament\Clusters\Places\Resources\Streets\Pages\EditStreet;
use App\Filament\Clusters\Places\Resources\Streets\Pages\ListStreets;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Near;
use App\Models\Street;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StreetResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = Street::class;
    protected static ?string $cluster=Places::class;
    protected static ?string $navigationLabel='أحياء';
    protected static ?int $navigationSort=2;
    protected static ?string $pluralLabel='أحياء';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getSelect('city_id'),
                self::getInput('name','اسم الحي'),

                Hidden::make('user_id')->default(Auth::id())

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                self::getColumn('City.name'),
                self::getColumn('name'),
            ])
            ->filters([
                SelectFilter::make('city_id')->label('المدينه')
                ->relationship('City', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(function (Model $record){
                        return !Autistic::where('street_id',$record->id)->exists()
                            && !Near::where('street_id',$record->id)->exists();
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
            'index' => ListStreets::route('/'),
            'create' => CreateStreet::route('/create'),
            'edit' => EditStreet::route('/{record}/edit'),
        ];
    }
}
