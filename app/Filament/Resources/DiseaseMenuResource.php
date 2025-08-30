<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use App\Filament\Resources\DiseaseMenuResource\Pages\ListDiseaseMenus;
use App\Filament\Resources\DiseaseMenuResource\Pages\CreateDiseaseMenu;
use App\Filament\Resources\DiseaseMenuResource\Pages\EditDiseaseMenu;
use App\Filament\Resources\DiseaseMenuResource\Pages;
use App\Filament\Resources\DiseaseMenuResource\RelationManagers;
use App\Models\DiseaseMenu;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiseaseMenuResource extends Resource
{
    protected static ?string $model = DiseaseMenu::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='أبرز الأمراض';
    protected static ?int $navigationSort=2;
    protected static string | \UnitEnum | null $navigationGroup='اعدادات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('بيان المرض'),
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
            'index' => ListDiseaseMenus::route('/'),
            'create' => CreateDiseaseMenu::route('/create'),
            'edit' => EditDiseaseMenu::route('/{record}/edit'),
        ];
    }
}
