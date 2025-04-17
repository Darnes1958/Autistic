<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiseaseMenuResource\Pages;
use App\Filament\Resources\DiseaseMenuResource\RelationManagers;
use App\Models\DiseaseMenu;
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

class DiseaseMenuResource extends Resource
{
    protected static ?string $model = DiseaseMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel='أبرز الأمراض';
    protected static ?string $navigationGroup='اعدادات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            'index' => Pages\ListDiseaseMenus::route('/'),
            'create' => Pages\CreateDiseaseMenu::route('/create'),
            'edit' => Pages\EditDiseaseMenu::route('/{record}/edit'),
        ];
    }
}
