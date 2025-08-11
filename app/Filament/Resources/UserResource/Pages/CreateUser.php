<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected ?string $heading='';

    protected function handleRecordCreation(array $data): Model
    {
        $apiUrl = 'https://client.almasafa.ly/api/sms/Send';
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1laWRlbnRpZmllciI6IkFsd2FzZWV0IiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiQWRtaW4iLCJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9lbWFpbGFkZHJlc3MiOiJ0amp4ODM5MVhZIiwiZXhwIjoxNzg2NDQ2MTMxLCJpc3MiOiJodHRwczovL2NsaWVudC5hbG1hc2FmYS5seSIsImF1ZCI6Imh0dHBzOi8vY2xpZW50LmFsbWFzYWZhLmx5In0._qVYQTQ9wGW15V9Npb43VOewdr55Hu8oTMQHkJ-zsPM';
        $response = Http::withToken(Setting::first()->token)
            ->post(Setting::first()->url, [
                'phoneNumber' => $data['phoneNumber'],
                'message' => 'المشترك الكريم .. '.$data['name'].'.. '.Setting::first()->register_message,
                'senderID' => '13201'
            ]);
        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
