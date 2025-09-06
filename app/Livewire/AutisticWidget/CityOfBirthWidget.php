<?php

namespace App\Livewire\AutisticWidget;

use App\Models\City;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class CityOfBirthWidget extends TableWidget
{
    protected int | string | array $columnSpan = 1;
    public function table(Table $table): Table
    {
        return $table
            ->heading('مكان الميلاد')
            ->extraAttributes(['class' => 'table_head_amber'])
            ->striped()
            ->defaultPaginationPageOption(5)
            ->query(fn (): Builder => City::query()->has('Autistic'))
            ->columns([
                TextColumn::make('name')->label('مكان الميلاد'),
                TextColumn::make('autistic_count')
                ->counts('Autistic')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
