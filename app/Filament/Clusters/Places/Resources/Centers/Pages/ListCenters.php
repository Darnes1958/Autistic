<?php

namespace App\Filament\Clusters\Places\Resources\Centers\Pages;

use App\Filament\Clusters\Places\Resources\Centers\CenterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCenters extends ListRecords
{
    protected static string $resource = CenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
