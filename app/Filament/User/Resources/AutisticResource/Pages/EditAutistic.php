<?php

namespace App\Filament\User\Resources\AutisticResource\Pages;

use App\Filament\User\Resources\AutisticResource;
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
