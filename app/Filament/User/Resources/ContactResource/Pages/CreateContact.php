<?php

namespace App\Filament\User\Resources\ContactResource\Pages;

use App\Filament\User\Pages\Dashboard;
use App\Filament\User\Resources\ContactResource;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
    protected ?string $heading='';
    protected function getRedirectUrl(): string
    {
        return Dashboard::getUrl();
    }
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم تحزين البيانات')
            ->body('سيتم التواصل معكم قريباً ..... ');
    }
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('تخزين'),
            Actions\Action::make('ret')
                ->label('عودة')
            ->url(Dashboard::getUrl())
            ];
    }
}
