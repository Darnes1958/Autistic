<?php

namespace App\Filament\User\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected ?string $heading='';
    public function getColumns(): int | string | array
    {
        return 4;
    }
}
