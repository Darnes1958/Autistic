<?php

namespace App\Filament\User\Resources\ContactResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\User\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
