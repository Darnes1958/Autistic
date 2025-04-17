<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AmbitiousResource\Pages;
use App\Filament\Resources\AmbitiousResource\RelationManagers;
use App\Models\Ambitious;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmbitiousResource extends Resource
{
    protected static ?string $model = Ambitious::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='طموح الأسرة بالنسبة للحالة';
    protected static ?string $navigationGroup='اعدادات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                 ->required()
                ->label('بيان طموح الأسرة'),
                Hidden::make('user_id')
                    ->default(auth()->id())

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                 ->label('البيان')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
               //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAmbitiouses::route('/'),
            'create' => Pages\CreateAmbitious::route('/create'),
            'edit' => Pages\EditAmbitious::route('/{record}/edit'),
        ];
    }
}
