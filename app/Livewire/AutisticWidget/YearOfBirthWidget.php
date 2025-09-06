<?php

namespace App\Livewire\AutisticWidget;

use App\Models\Autistic;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class YearOfBirthWidget extends TableWidget
{
    protected int | string | array $columnSpan = 1;
public function getTableRecordKey(Model|array $record): string
{
    return uniqid();
}

    public function table(Table $table): Table
    {
        return $table
            ->heading('العدد حسب سنة الميلاد')
            ->extraAttributes(['class' => 'table_head_amber'])
            ->query(fn (): Builder => Autistic::query()
                ->selectRaw('year(birthday) as year,count(*) as count  ')
                ->groupBy(DB::raw('year(birthday)'))


            )
            ->defaultKeySort(false)

            ->defaultPaginationPageOption(5)
            ->defaultSort('year')
            ->striped()
            ->columns([
              TextColumn::make('year'),
              TextColumn::make('count'),

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
