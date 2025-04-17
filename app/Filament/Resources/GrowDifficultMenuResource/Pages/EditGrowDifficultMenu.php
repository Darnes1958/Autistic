<?php

namespace App\Filament\Resources\GrowDifficultMenuResource\Pages;

use App\Filament\Resources\GrowDifficultMenuResource;
use App\Models\GrowDifficult;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrowDifficultMenu extends EditRecord
{
    protected static string $resource = GrowDifficultMenuResource::class;
    protected ?string $heading='تعديل بيانات صعوبات النمو';


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(!GrowDifficult::where('grow_difficult_menu_id', $this->getRecord()->id)->exists()),
        ];
    }
}
