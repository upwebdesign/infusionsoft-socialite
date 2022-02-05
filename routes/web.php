<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use InfusionsoftSocialite\Events\InfusionsoftSocialiteAuthenticated;

Route::name('auth.infusionsoft')
    ->middleware('web')
    ->group(function () {
        if (!env('INFUSIONSOFT_AUTH_URI')) {
            Route::get('/auth/infusionsoft/redirect', function (): RedirectResponse {
                return Socialite::driver('infusionsoft')->redirect();
            })->name('redirect');
        }

        if (!env('INFUSIONSOFT_REDIRECT_URI')) {
            Route::get('/auth/infusionsoft/callback', function (): void {
                dd(Socialite::driver('infusionsoft')->user());
                InfusionsoftSocialiteAuthenticated::dispatch(Socialite::driver('infusionsoft')->user());
            })->name('callback');
        }
    });
