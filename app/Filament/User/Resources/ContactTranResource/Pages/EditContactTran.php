<?php

namespace App\Filament\User\Resources\ContactTranResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\User\Resources\ContactTranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactTran extends EditRecord
{
    protected static string $resource = ContactTranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
