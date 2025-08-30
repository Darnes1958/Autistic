<?php

namespace App\Filament\Clusters\Places\Resources\Centers\Pages;

use App\Filament\Clusters\Places\Resources\Centers\CenterResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCenter extends EditRecord
{
    protected static string $resource = CenterResource::class;
protected ?string $heading='تعديل مركز توحد';
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

        ];
    }
}
