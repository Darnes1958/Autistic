<?php

namespace App\Filament\User\Resources\GrowthResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\User\Resources\GrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrowths extends ListRecords
{
    protected static string $resource = GrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
