<?php

namespace App\Filament\Resources\AmbitiousResource\Pages;

use App\Filament\Resources\AmbitiousResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmbitiouses extends ListRecords
{
    protected static string $resource = AmbitiousResource::class;
    protected ?string $heading='ادخال وتعديل بيانات طموح الأسرة بالنسبة للحالة';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('إضافة'),
        ];
    }
}
