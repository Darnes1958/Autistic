<?php

namespace App\Livewire\Widgets;

use App\Models\ContactTran;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class ShowContactTranWidget extends BaseWidget
{

    protected static ?string $heading='';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                function (ContactTran $query ) {
                    $query=ContactTran::where('user_receive',Auth::id());
                    return $query;
                }
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('بتاريخ'),
                TextColumn::make('message')
                    ->label('نص الرسالة')
                    ->sortable(),
                TextColumn::make('User.name')
                    ->label('بواسطة'),
            ]);
    }
}
