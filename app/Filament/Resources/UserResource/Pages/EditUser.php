<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\UserResource;
use App\Models\Autistic;
use App\Models\Boy;
use App\Models\Family;
use App\Models\Growth;
use App\Models\Medicine;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected ?string $heading=' ';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
             ->modalHeading('حذف السجل')
             ->before(function (User $record) {
                 autistic::where('user_id',$record->id)->delete();
                 Family::where('user_id',$record->id)->delete();
                 Growth::where('user_id',$record->id)->delete();
                 Boy::where('user_id',$record->id)->delete();
                 Medicine::where('user_id',$record->id)->delete();
             }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $res=Autistic::where('user_id',$record->id)->first();
        if ($res) {$res->center_id=$record->center_id;$res->save();}

        $record->update($data);

        return $record;
    }

}
