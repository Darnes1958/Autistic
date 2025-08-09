<?php

namespace App\Filament\Pages;

use App\Models\Contact;
use Filament\Actions\StaticAction;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use function Livewire\after;


class ShowContact extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.show-contact';
    protected static ?string $navigationLabel='صندوق الوارد';
    protected ?string $heading='';
    public static function getNavigationBadge(): ?string
    {
        $status=Contact::where('status',0)->count() ;
        if($status==0){$status=null;}
        return $status;
    }

    protected static ?int $navigationSort=2;

    public function table(Table $table): Table
    {
        return $table
            ->query(function (Contact $contact){
                return Contact::query();
            })

            ->columns([
                TextColumn::make('user.name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label('النص')
                    ->searchable()
                    ->action(
                        Action::make('contact_info')
                            ->label('نص الرسالة')
                            ->modalSubmitAction(fn (StaticAction $action) => $action->label('تمت القراءة'))
                            ->modalCancelAction(fn (StaticAction $action) => $action->label('عودة'))
                            ->after(function (Model $record) {
                                $record->status=1;

                                    $record->save();
                                })
                            ->action(function (Model $record) {

                            })
                            ->infolist([
                                Section::make()
                                    ->schema([
                                        TextEntry::make('message')
                                            ->label(''),
                                    ])
                                    ->columns(5),
                            ])
                    )
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('بتاريخ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->searchable()
                    ->sortable(),

            ]);
    }


}
