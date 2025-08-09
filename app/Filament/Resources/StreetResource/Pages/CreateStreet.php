<?php

namespace App\Filament\Resources\StreetResource\Pages;

use App\Filament\Resources\StreetResource;
use Filament\Actions;
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
