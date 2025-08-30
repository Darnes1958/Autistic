<?php

namespace App\Filament\Resources\StreetResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\StreetResource;
use App\Models\Autistic;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStreet extends EditRecord
{
    protected static string $resource = StreetResource::class;
    protected ?string $heading=' ';
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->visible(!Autistic::where('street_id', $this->getRecord()->id)->exists())
                ->modalHeading('حذف السجل')
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
