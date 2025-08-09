<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Places;
use App\Filament\Resources\StreetResource\Pages;
use App\Filament\Resources\StreetResource\RelationManagers;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Near;
use App\Models\Street;
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

class StreetResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = Street::class;
    protected static ?string $cluster=Places::class;
    protected static ?string $navigationLabel='أحياء';
    protected static ?int $navigationSort=2;
    protected static ?string $pluralLabel='أحياء';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Filters\SelectFilter::make('city_id')->label('المدينه')
                ->relationship('City', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Model $record){
                        return !Autistic::where('street_id',$record->id)->exists()
                            && !Near::where('street_id',$record->id)->exists();
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
            'index' => Pages\ListStreets::route('/'),
            'create' => Pages\CreateStreet::route('/create'),
            'edit' => Pages\EditStreet::route('/{record}/edit'),
        ];
    }
}
