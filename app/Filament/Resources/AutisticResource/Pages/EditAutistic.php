<?php

namespace App\Filament\Resources\AutisticResource\Pages;

use App\Filament\Resources\AutisticResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAutistic extends EditRecord
{
    protected static string $resource = AutisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
