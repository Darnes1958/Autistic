<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\ContactTranResource\Pages;
use App\Filament\User\Resources\ContactTranResource\RelationManagers;
use App\Models\ContactTran;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ContactTranResource extends Resource
{
    protected static ?string $model = ContactTran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                function (ContactTran $query ) {
                    $query=ContactTran::where('user_receive',Auth::id());
                    return $query;
                }
            )
            ->paginated(function (ContactTran $record){
                if ($record->count()>5) return true; else return  false;
            })
            ->striped()
            ->defaultSort('created_at','desc')
            ->columns([
                TextColumn::make('created_at')
                    ->color(function (Model $record) {
                        if ($record->isRead==0) return 'success'; else return 'gray';

                    })
                    ->sortable()
                    ->searchable()
                    ->label('بتاريخ'),
                TextColumn::make('message')
                    ->label('نص الرسالة')
                    ->searchable()
                    ->tooltip('أنقر هنا لقراءة كامل النص')
                    ->color(function (Model $record) {
                       if ($record->isRead==0) return 'success'; else return 'gray';

                    })
                    ->action(
                        Tables\Actions\Action::make('showTran')
                            ->label('نص الرسالة')
                            ->modalSubmitAction(false)
                            ->mountUsing(function (Model $record, Pages\ListContactTrans $livewire) {
                                $record->isread=1;
                                $record->save();
                                $livewire->dispatch('refreshContact');

                            })

                            ->modalCancelAction(fn (StaticAction $action) => $action->label('عودة')
                            )
                            ->infolist([
                                Section::make()
                                    ->schema([
                                        TextEntry::make('message')
                                            ->label(''),
                                    ])
                                    ,
                            ])

                    )
                    ->sortable(),

            ])
            ->recordUrl(false)
            ->filters([
                //
            ])
            ->actions([
                //
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
            'index' => Pages\ListContactTrans::route('/'),
            'create' => Pages\CreateContactTran::route('/create'),
            'edit' => Pages\EditContactTran::route('/{record}/edit'),
        ];
    }
}
