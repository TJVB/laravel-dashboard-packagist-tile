<?php

namespace TJVB\PackagistTile\Tests\Livewire;

use Livewire\Livewire;
use TJVB\PackagistTile\Contracts\PackagistStore;
use TJVB\PackagistTile\PackageData;
use TJVB\PackagistTile\PackagistTileComponent;
use TJVB\PackagistTile\Tests\_fixtures\PackagistStoreFixture;
use TJVB\PackagistTile\Tests\TestCase;

class PackagistTileComponentTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function weCanHandleTheTileWithoutPackageData(): void
    {
        // Arrange: create dependencies and test doubles
        $this->swap(PackagistStore::class, new PackagistStoreFixture());
        // Act: Execute the code

        // Assert: Verify the result of the code
        Livewire::test(PackagistTileComponent::class)
            ->assertSee(trans('dashboard-packagist-tile::packagisttile.Package'));
    }

    /**
     * @return void
     *
     * @test
     */
    public function weSeeThePackageDataInTheTile(): void
    {
        // Arrange: create dependencies and test doubles
        $store = new PackagistStoreFixture();
        $packageDataValues = require self::FIXTURES_PATH . 'packagedataArray.php';
        $packageData = PackageData::fromArray($packageDataValues);
        $store->packagesData[] = $packageData;
        $this->swap(PackagistStore::class, $store);

        // Assert: Verify the result of the code
        Livewire::test(PackagistTileComponent::class)
            ->set('page', 1)
            ->set('perPage', 10)
            ->assertSee($packageData->getName())
        ;
    }
}
