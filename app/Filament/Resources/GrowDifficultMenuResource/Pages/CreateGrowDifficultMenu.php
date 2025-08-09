<?php

namespace App\Filament\Resources\GrowDifficultMenuResource\Pages;

use App\Filament\Resources\GrowDifficultMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGrowDifficultMenu extends CreateRecord
{
    protected static string $resource = GrowDifficultMenuResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
