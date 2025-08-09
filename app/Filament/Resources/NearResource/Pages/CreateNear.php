<?php

namespace App\Filament\Resources\NearResource\Pages;

use App\Filament\Resources\NearResource;
use Filament\Actions;
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
