<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use App\Filament\Resources\AmbitiousResource\Pages\ListAmbitiouses;
use App\Filament\Resources\AmbitiousResource\Pages\CreateAmbitious;
use App\Filament\Resources\AmbitiousResource\Pages\EditAmbitious;
use App\Filament\Resources\AmbitiousResource\Pages;
use App\Filament\Resources\AmbitiousResource\RelationManagers;
use App\Models\Ambitious;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmbitiousResource extends Resource
{
    protected static ?string $model = Ambitious::class;


    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='طموح الأسرة بالنسبة للحالة';
    protected static string | \UnitEnum | null $navigationGroup='اعدادات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
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
            'index' => ListAmbitiouses::route('/'),
            'create' => CreateAmbitious::route('/create'),
            'edit' => EditAmbitious::route('/{record}/edit'),
        ];
    }
}
