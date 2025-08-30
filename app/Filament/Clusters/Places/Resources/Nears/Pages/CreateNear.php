<?php

namespace App\Filament\Clusters\Places\Resources\Nears\Pages;

use App\Filament\Clusters\Places\Resources\Nears\NearResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNear extends CreateRecord
{
    protected static string $resource = NearResource::class;
    protected ?string $heading='';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        info($data);
        return static::getModel()::create($data);
    }
}
