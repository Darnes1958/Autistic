<?php

namespace App\Filament\Clusters\Places\Resources\Nears\Pages;

use App\Filament\Clusters\Places\Resources\Nears\NearResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNears extends ListRecords
{
    protected static string $resource = NearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة'),
        ];
    }

}
