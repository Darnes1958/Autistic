<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Places;
use App\Filament\Resources\CenterResource\Pages;
use App\Filament\Resources\CenterResource\RelationManagers;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Center;
use App\Models\Near;
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

class CenterResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = Center::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster=Places::class;
    protected static ?string $navigationLabel='مراكز التوحد';
    protected static ?string $pluralLabel='مراكز التوحد';
    protected static ?int $navigationSort=4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::getSelect('city_id')->inlineLabel(false),
                self::getInput('name','اسم المركز')->unique(ignoreRecord: true)->inlineLabel(false),
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
                        return !Autistic::where('center_id',$record->id)->exists()
                           ;
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
            'index' => Pages\ListCenters::route('/'),
            'create' => Pages\CreateCenter::route('/create'),
            'edit' => Pages\EditCenter::route('/{record}/edit'),
        ];
    }
}
