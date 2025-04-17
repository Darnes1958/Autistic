<?php

namespace App\Filament\Resources\GrowDifficultMenuResource\Pages;

use App\Filament\Resources\GrowDifficultMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrowDifficultMenus extends ListRecords
{
    protected static string $resource = GrowDifficultMenuResource::class;
    protected ?string $heading='ادخال وتعديل بيانات صعوبات النمو';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('إضافة'),
        ];
    }
}
