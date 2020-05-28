<?php

namespace TJVB\PackagistTile\Tests;

use TJVB\PackagistTile\Contracts\PackagistService;
use TJVB\PackagistTile\Contracts\PackagistStore;
use TJVB\PackagistTile\FetchPackageDataCommand;
use TJVB\PackagistTile\PackageData;
use TJVB\PackagistTile\Tests\_fixtures\PackagistServiceFixture;
use TJVB\PackagistTile\Tests\_fixtures\PackagistStoreFixture;

class FetchPackageDataCommandTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function weCanFetchThePackagesDataFromPackagist(): void
    {
        // Arrange: create dependencies and test doubles
        $packagistStore = new PackagistStoreFixture();
        $packageDataValues = require self::FIXTURES_PATH . 'packagedataArray.php';
        $packageData = PackageData::fromArray($packageDataValues);

        $packagistService = new PackagistServiceFixture();
        $packagistService->packageData = $packageData;

        $this->swap(PackagistService::class, $packagistService);
        $this->swap(PackagistStore::class, $packagistStore);

        config(['dashboard.tiles.packagist.packages' => ['tjvb/laravel-dashboard-packagist-tile']]);

        // Act: Execute the code
        $this->artisan(FetchPackageDataCommand::class)
            ->expectsOutput('Fetching package data from packagist ...')
            ->expectsOutput('All done!')
            ->assertExitCode(0);

        // Assert: Verify the result of the code
        $this->assertEquals([$packageData], $packagistStore->packagesData);
    }
}
