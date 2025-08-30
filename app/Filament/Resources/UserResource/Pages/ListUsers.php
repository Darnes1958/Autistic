<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
protected ?string $heading=' ';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()

                ->label('اضافة حالة'),
        ];
    }
}
