<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class PackagistTileServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public array $bindings = [
        \TJVB\PackagistTile\Contracts\PackagistStore::class => PackagistStore::class,
    ];
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchPackageDataCommand::class,
                FetchVendorPackagesCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-packagist-tile'),
        ], 'dashboard-packagist-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-packagist-tile');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'dashboard-packagist-tile');

        Livewire::component('packagist-tile', PackagistTileComponent::class);
    }
}
