<?php

namespace TJVB\PackagistTile\Tests;

use Livewire\LivewireServiceProvider;
use Spatie\Dashboard\DashboardServiceProvider;
use TJVB\PackagistTile\PackagistTileServiceProvider;

/**
 * The base TestCase for all the tests we have
 *
 * @author Tobias van Beek <t.vanbeek@tjvb.nl>
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    public const FIXTURES_PATH = __DIR__ . '/_fixtures/';

    /**
     * Get the custom Service Provider
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            PackagistTileServiceProvider::class,
            LivewireServiceProvider::class,
            DashboardServiceProvider::class,
        ];
    }
}
