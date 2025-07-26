<?php

namespace MohamedHekal\LaravelFeatureBox;

use Illuminate\Support\ServiceProvider;
use MohamedHekal\LaravelFeatureBox\Commands\EnableFeatureCommand;
use MohamedHekal\LaravelFeatureBox\Commands\DisableFeatureCommand;
use MohamedHekal\LaravelFeatureBox\Commands\ListFeaturesCommand;
use MohamedHekal\LaravelFeatureBox\Contracts\FeatureBoxInterface;
use MohamedHekal\LaravelFeatureBox\FeatureBox;

class FeatureBoxServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/featurebox.php',
            'featurebox'
        );

        $this->app->singleton(FeatureBoxInterface::class, function ($app) {
            return new FeatureBox();
        });

        $this->app->alias(FeatureBoxInterface::class, 'featurebox');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/featurebox.php' => config_path('featurebox.php'),
            ], 'featurebox-config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'featurebox-migrations');

            $this->commands([
                EnableFeatureCommand::class,
                DisableFeatureCommand::class,
                ListFeaturesCommand::class,
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
