<?php

namespace App\Filament\Resources\AutisticResource\Pages;

use App\Filament\Resources\AutisticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutistics extends ListRecords
{
    protected static string $resource = AutisticResource::class;
    protected ?string $heading=' ';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('إضافة حالة جديدة'),
        ];
    }
}
