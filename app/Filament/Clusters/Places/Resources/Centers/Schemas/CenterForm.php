<?php

namespace App\Filament\Clusters\Places\Resources\Centers\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class CenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('city_id')
                    ->relationship('City', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Hidden::make('user_id')
                    ->default(Auth::id()),
            ]);
    }
}
