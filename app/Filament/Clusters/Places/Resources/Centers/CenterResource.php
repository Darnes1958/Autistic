<?php

namespace App\Filament\Clusters\Places\Resources\Centers;

use App\Filament\Clusters\Places;
use App\Filament\Clusters\Places\Resources\Centers\Pages\CreateCenter;
use App\Filament\Clusters\Places\Resources\Centers\Pages\EditCenter;
use App\Filament\Clusters\Places\Resources\Centers\Pages\ListCenters;
use App\Filament\Clusters\Places\Resources\Centers\Pages\ViewCenter;
use App\Filament\Clusters\Places\Resources\Centers\Schemas\CenterForm;
use App\Filament\Clusters\Places\Resources\Centers\Schemas\CenterInfolist;
use App\Filament\Clusters\Places\Resources\Centers\Tables\CentersTable;
use App\Models\Center;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CenterResource extends Resource
{
    protected static ?string $model = Center::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = Places::class;
    protected static ?string $pluralModelLabel='مراكز التوحد';

    public static function form(Schema $schema): Schema
    {
        return CenterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CenterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CentersTable::configure($table);
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
            'view' => ViewCenter::route('/{record}'),
            'edit' => EditCenter::route('/{record}/edit'),
        ];
    }
}
