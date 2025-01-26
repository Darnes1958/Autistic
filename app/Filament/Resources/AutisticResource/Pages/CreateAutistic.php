<?php

namespace App\Filament\Resources\AutisticResource\Pages;

use App\Filament\Resources\AutisticResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAutistic extends CreateRecord
{
    protected static string $resource = AutisticResource::class;

    protected static bool $canCreateAnother = false;

    protected ?string $heading='شاشة ادخال وتعديل حالة توحد';
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()

            ->extraAttributes(['type' => 'button', 'wire:click' => 'create'])
            ;
    }


}
