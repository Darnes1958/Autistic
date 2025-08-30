<?php

namespace App\Filament\Resources\CityResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\CityResource;
use App\Models\Autistic;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->visible(!Autistic::where('city_id', $this->getRecord()->id)->exists())
                ->modalHeading('حذف السجل')
        ];
    }
    protected ?string $heading=' ';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
