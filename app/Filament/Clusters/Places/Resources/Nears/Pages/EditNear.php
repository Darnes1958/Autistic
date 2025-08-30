<?php

namespace App\Filament\Clusters\Places\Resources\Nears\Pages;

use App\Filament\Clusters\Places\Resources\Nears\NearResource;
use App\Models\Autistic;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNear extends EditRecord
{
    protected static string $resource = NearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->visible(!Autistic::where('near_id', $this->getRecord()->id)->exists())
                ->modalHeading('حذف السجل'),
        ];
    }
    protected ?string $heading=' ';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
