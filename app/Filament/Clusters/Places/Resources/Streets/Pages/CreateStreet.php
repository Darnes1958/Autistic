<?php

namespace App\Filament\Clusters\Places\Resources\Streets\Pages;

use App\Filament\Clusters\Places\Resources\Streets\StreetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStreet extends CreateRecord
{
    protected ?string $heading='';
    protected static string $resource = StreetResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
