<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use App\Filament\Resources\GrowDifficultMenuResource\Pages\ListGrowDifficultMenus;
use App\Filament\Resources\GrowDifficultMenuResource\Pages\CreateGrowDifficultMenu;
use App\Filament\Resources\GrowDifficultMenuResource\Pages\EditGrowDifficultMenu;
use App\Filament\Resources\GrowDifficultMenuResource\Pages;
use App\Filament\Resources\GrowDifficultMenuResource\RelationManagers;
use App\Models\GrowDifficultMenu;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GrowDifficultMenuResource extends Resource
{
    protected static ?string $model = GrowDifficultMenu::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='الصعوبات النمائية';
    protected static string | \UnitEnum | null $navigationGroup='اعدادات';
    protected static ?int $navigationSort=3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('بيان الصعوبة'),
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
            'index' => ListGrowDifficultMenus::route('/'),
            'create' => CreateGrowDifficultMenu::route('/create'),
            'edit' => EditGrowDifficultMenu::route('/{record}/edit'),
        ];
    }
}
