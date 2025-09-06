<?php

namespace App\Livewire\AutisticWidget;

use App\Models\Autistic;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MonthOfBirthWidget extends TableWidget
{
    protected int | string | array $columnSpan = 1;
    public function getTableRecordKey(Model|array $record): string
    {
        return uniqid();
    }
    public function table(Table $table): Table
    {
        return $table
            ->heading('العدد حسب شهر الميلاد')
            ->extraAttributes(['class' => 'table_head_amber'])
            ->striped()
            ->query(fn (): Builder => Autistic::query()
                ->selectRaw('month(birthday) as month,count(*) as count  ')
                ->groupBy(DB::raw('month(birthday)'))


            )

            ->defaultKeySort(false)
            ->defaultSort('month')
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('month'),
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
