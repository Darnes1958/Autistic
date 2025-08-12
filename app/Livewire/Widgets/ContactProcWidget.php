<?php

namespace App\Livewire\Widgets;

use App\Models\Contact;
use App\Models\ContactProc;

use Faker\Provider\Text;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ContactProcWidget extends BaseWidget
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
                function (ContactProc $query ) {
                    $query=ContactProc::where('contact_id',$this->contact_id);
                    return $query;
                }
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('بتاريخ'),
                TextColumn::make('proc_type')
                    ->label('نوع الإجراء')
                    ->sortable(),
                TextColumn::make('proc')
                    ->label('البيان')
                    ->sortable(),
                TextColumn::make('User.name')
                    ->label('بواسطة'),
            ])
            ->actions([
                DeleteAction::make()
                    ->modalHeading('حذف السجل')
                 ->after(function (){
                     $res=ContactProc::where('contact_id',$this->contact_id)->first();
                     if ($res) Contact::find($this->contact_id)->update(['status'=>$res->proc_type]);
                     else Contact::find($this->contact_id)->update(['status'=>1]);
                 })->iconButton(),
                Action::make('edit')
                 ->icon('heroicon-o-pencil')
                 ->iconButton()
                 ->color('primary')
                    ->modalHeading('')
                    ->modalSubmitAction(fn(StaticAction $action)=>$action->label('تخزين'))
                 ->fillForm(fn(ContactProc $record):array => ['proc'=>$record->proc])
                 ->form([
                     TextInput::make('proc')
                      ->required()
                      ->label('الإجراء')
                 ])
                ->action(function (ContactProc $record,array $data) {$record->proc=$data['proc'];$record->save();})

            ]);
    }
}
