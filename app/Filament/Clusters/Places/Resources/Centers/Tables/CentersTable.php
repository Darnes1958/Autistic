<?php

namespace App\Filament\Clusters\Places\Resources\Centers\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CentersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('City.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('User.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()->visible(function (Model $record) {return !User::where('center_id',$record->id)->exists();}),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()

                ]),
            ])->checkIfRecordIsSelectableUsing(
            function (Model $record) {return !User::where('center_id',$record->id)->exists();}
             );
    }
}
