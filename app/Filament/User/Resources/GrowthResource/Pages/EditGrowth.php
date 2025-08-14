<?php

namespace App\Filament\User\Resources\GrowthResource\Pages;

use App\Filament\User\Resources\GrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrowth extends EditRecord
{
    protected static string $resource = GrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
