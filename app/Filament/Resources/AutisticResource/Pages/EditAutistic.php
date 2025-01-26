<?php

namespace App\Filament\Resources\AutisticResource\Pages;

use App\Filament\Resources\AutisticResource;
use Filament\Actions;
use Filament\Actions\Action;
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
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()

            ->extraAttributes(['type' => 'button', 'wire:click' => 'save'])
            ;
    }


}
