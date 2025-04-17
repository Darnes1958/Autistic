<?php

namespace App\Filament\Resources\DiseaseMenuResource\Pages;

use App\Filament\Resources\DiseaseMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiseaseMenus extends ListRecords
{
    protected static string $resource = DiseaseMenuResource::class;
    protected ?string $heading='ادخال وتعديل بيانات أمراض أخري';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('إضافة'),
        ];
    }
}
