<?php

namespace App\Filament\Clusters\Places\Resources\Cites\Pages;

use App\Filament\Clusters\Places\Resources\Cites\CityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;
    protected ?string $heading='';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
