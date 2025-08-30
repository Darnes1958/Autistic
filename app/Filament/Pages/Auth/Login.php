<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Components\Component;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Filament\Schemas\Schema;

class Login extends \Filament\Auth\Pages\Login
{

    public function form(Schema $schema): Schema
    {
        return $schema

        ->components([
                        $this->getNatFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ]);


    }
    protected function getCompCodeFormComponent(): Component
    {
        return TextInput::make('CompCode')
            ->label('كود الشركة')
            ->numeric()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }
    protected function getNatFormComponent(): Component
    {
        return TextInput::make('nat')
            ->label('الرقم الوطني')
            ->numeric()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }
    protected function getIdFormComponent(): Component
    {
        return TextInput::make('id')
            ->label('رقم المستخدم')
            ->numeric()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'nat' => $data['nat'],
            'password' => $data['password'],

        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.id' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();




        if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();





        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentOrDefaultPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
