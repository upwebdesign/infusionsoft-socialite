<?php

namespace InfusionsoftSocialite;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use InfusionsoftSocialite\InfusionsoftSocialite;
use InfusionsoftSocialite\Events\InfusionsoftSocialiteAuthenticated;

class InfusionsoftSocialiteServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        $this->registerSocialite();
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        // $events = $this->app->make(Dispatcher::class);
        // $events->listen(InfusionsoftSocialiteAuthenticated::class);
    }

    /**
     * Register Socialite
     *
     * @return void
     */
    public function registerSocialite(): void
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend('infusionsoft', function ($app) use ($socialite) {
            $config = $app['config']['services.infusionsoft'];
            return $socialite->buildProvider(InfusionsoftSocialite::class, $config);
        });
    }
}
