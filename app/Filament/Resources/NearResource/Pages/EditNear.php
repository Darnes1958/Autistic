<?php

namespace App\Filament\Resources\NearResource\Pages;

use App\Filament\Resources\NearResource;
use App\Models\Autistic;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNear extends EditRecord
{
    protected static string $resource = NearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->visible(!Autistic::where('near_id', $this->getRecord()->id)->exists())
                ->modalHeading('حذف السجل'),
        ];
    }
    protected ?string $heading=' ';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
