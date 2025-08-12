<?php

namespace App\Livewire\Widgets;

use App\Models\Contact;
use App\Models\ContactProc;

use App\Models\ContactTran;
use Faker\Provider\Text;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class ContactTranWidget extends BaseWidget
{
    public function mount($contact_id){
    $this->contact_id=$contact_id;
}
    protected static ?string $heading='';
    public $contact_id;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                function (ContactTran $query ) {
                    $query=ContactTran::where('contact_id',$this->contact_id);
                    return $query;
                }
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('بتاريخ'),
                TextColumn::make('message')
                    ->label('نص الرسالة')
                    ->sortable(),
                TextColumn::make('User.name')
                    ->label('بواسطة'),
            ])
            ->headerActions([
                    CreateAction::make('createTran')
                        ->label('إضافة رسالة')
                        ->modalHeading(false)
                        ->createAnother(false)
                        ->model(ContactTran::class)
                        ->form([
                            Textarea::make('message')
                                ->required()
                                ->rows(3)
                                ->label('النص'),
                            Hidden::make('user_id')->default(Auth::id()),
                            Hidden::make('user_receive')->default(Contact::find($this->contact_id)->user_id),
                            Hidden::make('contact_id')->default($this->contact_id),
                        ]),
                ]
            )
            ->actions([
                DeleteAction::make()
                    ->modalHeading('حذف السجل')
                    ->iconButton(),
                Action::make('edit')
                 ->icon('heroicon-o-pencil')
                 ->iconButton()
                 ->color('primary')
                    ->modalHeading('')
                    ->modalSubmitAction(fn(StaticAction $action)=>$action->label('تخزين'))
                 ->fillForm(fn(ContactTran $record):array => ['message'=>$record->message])
                 ->form([
                     Textarea::make('message')
                      ->required()
                      ->rows(3)
                      ->label('النص')
                 ])
                ->action(function (ContactTran $record,array $data) {$record->message=$data['message'];$record->save();})

            ]);
    }
}
