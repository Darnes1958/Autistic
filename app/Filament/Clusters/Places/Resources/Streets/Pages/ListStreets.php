<?php

namespace App\Filament\Clusters\Places\Resources\Streets\Pages;

use App\Filament\Clusters\Places\Resources\Streets\StreetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStreets extends ListRecords
{
    protected static string $resource = StreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة'),
        ];
    }

}
