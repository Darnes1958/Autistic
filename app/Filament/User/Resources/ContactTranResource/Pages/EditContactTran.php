<?php

namespace App\Filament\User\Resources\ContactTranResource\Pages;

use App\Filament\User\Resources\ContactTranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactTran extends EditRecord
{
    protected static string $resource = ContactTranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
