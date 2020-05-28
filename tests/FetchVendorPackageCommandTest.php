<?php

namespace TJVB\PackagistTile\Tests;

use TJVB\PackagistTile\Contracts\PackagistService;
use TJVB\PackagistTile\Contracts\PackagistStore;
use TJVB\PackagistTile\FetchVendorPackagesCommand;
use TJVB\PackagistTile\Tests\_fixtures\PackagistServiceFixture;
use TJVB\PackagistTile\Tests\_fixtures\PackagistStoreFixture;

class FetchVendorPackageCommandTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function weCanFetchTheVendorPackagesFromPackagist(): void
    {
        // Arrange: create dependencies and test doubles
        $vendorPackages = [
            'tjvb/laravel-dashboard-packagist-tile',
        ];
        $packagistService = new PackagistServiceFixture();
        $packagistStore = new PackagistStoreFixture();
        $packagistService->vendorPackages = $vendorPackages;

        $this->swap(PackagistService::class, $packagistService);
        $this->swap(PackagistStore::class, $packagistStore);

        config(['dashboard.tiles.packagist.vendors' => ['tjvb']]);

        // Act: Execute the code
        $this->artisan(FetchVendorPackagesCommand::class)
            ->expectsOutput('Fetching vendor packages from packagist ...')
            ->expectsOutput('All done!')
            ->assertExitCode(0);

        // Assert: Verify the result of the code
        $this->assertEquals($vendorPackages, $packagistStore->vendorPackages);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weDontBreakIfWeDontHaveAnyVendorSpecified(): void
    {
        // Arrange: create dependencies and test doubles
        $vendorPackages = [
            'tjvb/laravel-dashboard-packagist-tile',
        ];
        $packagistService = new PackagistServiceFixture();
        $packagistStore = new PackagistStoreFixture();
        $packagistService->vendorPackages = $vendorPackages;

        $this->swap(PackagistService::class, $packagistService);
        $this->swap(PackagistStore::class, $packagistStore);

        config(['dashboard.tiles.packagist.vendors' => []]);

        // Act: Execute the code
        $this->artisan(FetchVendorPackagesCommand::class)
            ->expectsOutput('Fetching vendor packages from packagist ...')
            ->expectsOutput('All done!')
            ->assertExitCode(0);

        // Assert: Verify the result of the code
        $this->assertEmpty($packagistStore->vendorPackages);
    }
}
