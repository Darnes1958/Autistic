<?php

namespace App\Filament\User\Resources\AutisticResource\Pages;

use App\Filament\User\Resources\AutisticResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAutistic extends CreateRecord
{
    protected static string $resource = AutisticResource::class;
    protected ?string $heading='بيانات أولية';
}
