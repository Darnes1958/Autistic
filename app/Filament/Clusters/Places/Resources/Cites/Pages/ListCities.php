<?php

namespace App\Filament\Clusters\Places\Resources\Cites\Pages;

use App\Filament\Clusters\Places\Resources\Cites\CityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة'),
        ];
    }

}
