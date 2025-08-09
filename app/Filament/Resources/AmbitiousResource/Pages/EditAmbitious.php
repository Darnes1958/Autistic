<?php

namespace App\Filament\Resources\AmbitiousResource\Pages;

use App\Filament\Resources\AmbitiousResource;
use App\Models\Autistic;
use App\Models\Boy;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAmbitious extends EditRecord
{
    protected static string $resource = AmbitiousResource::class;
    protected ?string $heading='تعديل بيانات طموح الأسرة بالنسبة للحالة';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(!Boy::where('ambitious_id', $this->getRecord()->id)->exists())
                ->modalHeading('حذف السجل')
            ,
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
