<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\CenterResource\Pages\ListCenters;
use App\Filament\Resources\CenterResource\Pages\CreateCenter;
use App\Filament\Resources\CenterResource\Pages\EditCenter;
use App\Filament\Clusters\Places;
use App\Filament\Resources\CenterResource\Pages;
use App\Filament\Resources\CenterResource\RelationManagers;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\Center;
use App\Models\Near;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
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

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster=Places::class;
    protected static ?string $navigationLabel='مراكز التوحد';
    protected static ?string $pluralLabel='مراكز التوحد';
    protected static ?int $navigationSort=4;


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                SelectFilter::make('city_id')->label('المدينه')
                    ->relationship('City', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(function (Model $record){
                        return !Autistic::where('center_id',$record->id)->exists()
                           ;
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
            'index' => ListCenters::route('/'),
            'create' => CreateCenter::route('/create'),
            'edit' => EditCenter::route('/{record}/edit'),
        ];
    }
}
