<?php

namespace App\Filament\Resources\NearResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\NearResource;
use Filament\Actions;
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
