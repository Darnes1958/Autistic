<?php

namespace App\Filament\Clusters\Places\Resources\Centers\Pages;

use App\Filament\Clusters\Places\Resources\Centers\CenterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCenter extends ViewRecord
{
    protected static string $resource = CenterResource::class;
    protected ?string $heading='مراكز التوحد';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
