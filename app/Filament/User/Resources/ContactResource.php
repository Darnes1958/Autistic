<?php

namespace App\Filament\User\Resources;

use App\Enums\Contact\ContactType;
use App\Filament\User\Resources\ContactResource\Pages;
use App\Filament\User\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->is_admin;
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                ->schema([

                        Select::make('contactType')
                            ->required()
                            ->options(ContactType::class)
                            ->preload()
                            ->columnSpanFull()
                            ->label('تصنيف الطلب'),
                        Textarea::make('message')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('النص'),

                ])->columnSpan(1),

                Hidden::make('user_id')->default(Auth::id()),
                Hidden::make('status')->default(0),
            ])
            ->columns(2);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('User.name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_type')
                    ->label('التصنيف')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label('النص')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('بتاريخ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->searchable()
                    ->sortable(),

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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
