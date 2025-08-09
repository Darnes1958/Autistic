<?php

namespace App\Filament\Resources\CenterResource\Pages;

use App\Filament\Resources\CenterResource;
use App\Models\Autistic;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenter extends EditRecord
{
    protected static string $resource = CenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(!Autistic::where('center_id', $this->getRecord()->id)->exists())
                ->modalHeading('حذف السجل')

        ];
    }
    protected ?string $heading=' ';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
