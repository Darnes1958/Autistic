<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrowDifficultMenuResource\Pages;
use App\Filament\Resources\GrowDifficultMenuResource\RelationManagers;
use App\Models\GrowDifficultMenu;
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

class GrowDifficultMenuResource extends Resource
{
    protected static ?string $model = GrowDifficultMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='الصعوبات النمائية';
    protected static ?string $navigationGroup='اعدادات';
    protected static ?int $navigationSort=3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            'index' => Pages\ListGrowDifficultMenus::route('/'),
            'create' => Pages\CreateGrowDifficultMenu::route('/create'),
            'edit' => Pages\EditGrowDifficultMenu::route('/{record}/edit'),
        ];
    }
}
