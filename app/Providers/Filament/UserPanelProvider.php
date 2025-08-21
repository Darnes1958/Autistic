<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\User\Resources\GrowthResource;
use App\Http\Middleware\RedirectToProperPanelMiddleware;
use App\Models\Growth;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->darkMode(false)
            ->navigationItems([
                NavigationItem::make('تاريخ النمو')
               //     ->url('/user/growths/upd')
                    ->url(fn (): string => GrowthResource::getUrl('upd'))
                    ->visible(function (){
                      return  Growth::where('user_id',Auth::id())->first();
                    })
                    ->icon('heroicon-o-check')
                    ->sort(4)
                    ->isActiveWhen(fn () => request()->routeIs('filament.user.resources.growths.upd'))
                    ,
            ])
            ->profile(EditProfile::class)
            ->font('Amiri')


            ->viteTheme('resources/css/filament/user/theme.css')
            ->sidebarFullyCollapsibleOnDesktop()
            ->login(Login::class)
            ->breadcrumbs(false)
            ->maxContentWidth('Full')
            ->id('user')
            ->path('user')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')
            ->pages([
               //
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
            ->widgets([
                //
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                RedirectToProperPanelMiddleware::class,
                Authenticate::class,
            ]);
    }
}
