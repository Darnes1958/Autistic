<?php

namespace App\Filament\User\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\Action;
use App\Filament\User\Resources\ContactTranResource\Pages\ListContactTrans;
use Filament\Schemas\Components\Section;
use App\Filament\User\Resources\ContactTranResource\Pages\CreateContactTran;
use App\Filament\User\Resources\ContactTranResource\Pages\EditContactTran;
use App\Filament\User\Resources\ContactTranResource\Pages;
use App\Filament\User\Resources\ContactTranResource\RelationManagers;
use App\Models\ContactTran;
use Filament\Forms;
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

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                        Action::make('showTran')
                            ->label('نص الرسالة')
                            ->modalSubmitAction(false)
                            ->mountUsing(function (Model $record, ListContactTrans $livewire) {
                                $record->isread=1;
                                $record->save();
                                $livewire->dispatch('refreshContact');

                            })

                            ->modalCancelAction(fn (Action $action) => $action->label('عودة')
                            )
                            ->schema([
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
            ->recordActions([
                //
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
            'index' => ListContactTrans::route('/'),
            'create' => CreateContactTran::route('/create'),
            'edit' => EditContactTran::route('/{record}/edit'),
        ];
    }
}
