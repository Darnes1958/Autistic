<?php

namespace App\Filament\Resources\DiseaseMenuResource\Pages;

use App\Filament\Resources\DiseaseMenuResource;
use App\Models\BoyDisease;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiseaseMenu extends EditRecord
{
    protected static string $resource = DiseaseMenuResource::class;
    protected ?string $heading='تعديل بيانات أمراض أخري';


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(!BoyDisease::where('disease_menu_id', $this->getRecord()->id)->exists())
            ->modalHeading('حذف السجل'),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
