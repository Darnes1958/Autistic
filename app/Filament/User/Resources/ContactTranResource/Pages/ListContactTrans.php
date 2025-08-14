<?php

namespace App\Filament\User\Resources\ContactTranResource\Pages;

use App\Filament\User\Resources\ContactTranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactTrans extends ListRecords
{
    protected static string $resource = ContactTranResource::class;

    protected ?string $heading='';
}
