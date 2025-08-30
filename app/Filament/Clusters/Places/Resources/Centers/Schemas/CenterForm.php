<?php

namespace App\Filament\Clusters\Places\Resources\Centers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('city_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
