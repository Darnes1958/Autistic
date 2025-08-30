<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Schemas\Components\Section;
use Filament\Actions\CreateAction;
use App\Enums\Contact\ContactType;
use App\Enums\Contact\Status;
use App\Models\Contact;

use App\Models\ContactProc;
use App\Models\ContactTran;
use App\Models\Sell;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use function Livewire\after;


class ShowContact extends Page implements HasTable
{
    use InteractsWithTable;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.show-contact';
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
            ->query(function (){
                return Contact::query();
            })

            ->columns([
                TextColumn::make('user.name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contactType')
                    ->label('التصنيف')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label('النص')
                    ->searchable()
                    ->action(
                        Action::make('contact_info')
                            ->label('نص الرسالة')
                            ->modalSubmitAction(fn (Action $action) => $action->label('تمت القراءة'))
                            ->modalCancelAction(fn (Action $action) => $action->label('عودة'))
                            ->after(function (Model $record) {
                                $record->status=1;

                                    $record->save();
                                })
                            ->action(function (Model $record) {

                            })
                            ->schema([
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
                    ->action(
                        CreateAction::make('createProc')
                            ->disabled(function (Contact $record){
                                return $record->status==Status::حفظت || $record->status==Status::تم_الإجراء;
                            })
                            ->modalHeading(false)
                            ->createAnother(false)
                            ->model(ContactProc::class)
                            ->schema([
                                TextInput::make('proc')
                                    ->required()
                                    ->label('الإجراء'),
                                Select::make('proc_type')
                                    ->label('نوع الإجراء')
                                    ->options([
                                        2=> 'تحت الإجراء' ,
                                        3=>   'تم الإجراء' ,
                                        4=>   'حفظت' ,
                                    ]),
                                Hidden::make('user_id')->default(Auth::id()),
                                Hidden::make('contact_id')->default(function (Contact $record) {return $record->id;})

                            ])
                            ->using(function (array $data, string $model): Model {
                                Contact::find($data['contact_id'])->update(['status' => $data['proc_type']]);
                                return $model::create($data);
                            })
                    )
                    ->searchable()
                    ->sortable(),

            ])
            ->recordActions([
                Action::make('procs')

                 //   ->visible(fn(Contact $record):bool =>ContactProc::where('contact_id',$record->id)->exists())
                    ->modalHeading(false)
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn (Action $action) => $action->label('عودة'))
                    ->modalContent(fn (Contact $record): View => view(
                        'filament.pages.views.view-contact-proc-widget',
                        ['contact_id' => $record->id],
                    ))
                    ->badge(function (Contact $record){
                        $count= ContactProc::where('contact_id',$record->id)->count();
                        if ($count==0) return null; else return $count;

                    } )
                    ->color(function (Contact $record){
                        if (ContactProc::where('contact_id',$record->id)->exists())
                            return 'success'; else return 'gray';
                    })
                    ->icon('heroicon-o-eye')
                    ->label('الإجراءات'),
                Action::make('messages')

                //    ->visible(fn(Contact $record):bool =>ContactTran::where('contact_id',$record->id)->exists())
                    ->badge(function (Contact $record){
                        $count= ContactTran::where('contact_id',$record->id)->count();
                        if ($count==0) return null; else return $count;

                } )
                    ->modalHeading(false)
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn (Action $action) => $action->label('عودة'))
                    ->modalContent(fn (Contact $record): View => view(
                        'filament.pages.views.view-contact-tran-widget',
                        ['contact_id' => $record->id],
                    ))
                    ->icon('heroicon-o-envelope')
                    ->color(function (Contact $record){
                        if (ContactTran::where('contact_id',$record->id)->exists())
                            return 'success'; else return 'gray';
                    })
                    ->label('الرسائل'),

            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(Status::class),
                SelectFilter::make('contactType')
                    ->label('التصنيف')
                    ->options(ContactType::class),
            ]);
    }


}
