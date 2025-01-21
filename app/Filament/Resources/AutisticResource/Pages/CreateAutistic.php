<?php

namespace App\Filament\Resources\AutisticResource\Pages;

use App\Filament\Resources\AutisticResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAutistic extends CreateRecord
{
    protected static string $resource = AutisticResource::class;
    protected ?string $heading='شاشة ادخال وتعديل حالة توحد';
}
