<?php

namespace TJVB\PackagistTile\Tests;

use TJVB\PackagistTile\PackageData;
use TJVB\PackagistTile\PackagistStore;
use TJVB\PackagistTile\Tests\_fixtures\TileFixture;

class PackagistStoreTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function weCanStoreTheVendorPackages(): void
    {
        // Arrange: create dependencies and test doubles
        $tile = new TileFixture();
        $vendors = [
            'tjvb/laravel-dashboard-packagist-tile',
            'tjvb/laravel-mail-catchall',
            'tjvb/testreportmixer',
        ];

        $store = new PackagistStore($tile);

        // Act: Execute the code
        $store->setVendorPackages($vendors);

        // Assert: Verify the result of the code
        $this->assertArrayHasKey('vendorPackages', TileFixture::firstOrCreateForName('packagist')->data);
        $this->assertEquals($vendors, TileFixture::firstOrCreateForName('packagist')->data['vendorPackages']);
    }

    /**
     * @return void
     *
     * @test
     *
     * @depends weCanStoreTheVendorPackages
     */
    public function weCanGetTheVendorPackagesFromTheStore(): void
    {
        // Arrange: create dependencies and test doubles
        $tile = new TileFixture();
        $vendors = [
            'tjvb/laravel-dashboard-packagist-tile',
            'tjvb/laravel-mail-catchall',
            'tjvb/testreportmixer',
        ];
        TileFixture::firstOrCreateForName('packagist')->data['vendorPackages'] = $vendors;

        // Act: Execute the code
        $store = new PackagistStore($tile);
        $vendorsResult = $store->getVendorPackages();

        // Assert: Verify the result of the code
        $this->assertEquals($vendors, $vendorsResult);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weCanStoreThePackagesData(): void
    {
        // Arrange: create dependencies and test doubles
        $tile = new TileFixture();

        $packageData = require self::FIXTURES_PATH . 'packagedataArray.php';
        $packageDataObject = PackageData::fromArray($packageData);

        // Act: Execute the code
        $store = new PackagistStore($tile);
        $store->setPackagesData([$packageDataObject]);

        // Assert: Verify the result of the code
        $this->assertArrayHasKey('packages', TileFixture::firstOrCreateForName('packagist')->data);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weDontCrashIfWeStorePlainData(): void
    {
        // Arrange: create dependencies and test doubles
        $tile = new TileFixture();

        // Act: Execute the code
        $store = new PackagistStore($tile);
        $store->setPackagesData(['key' => 'value']);

        // Assert: Verify the result of the code
        $this->assertArrayHasKey('packages', TileFixture::firstOrCreateForName('packagist')->data);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weGetThePackageDataThatWeStore(): void
    {
        // Arrange: create dependencies and test doubles
        $tile = new TileFixture();
        $packageData = require self::FIXTURES_PATH . 'packagedataArray.php';
        $packageDataObject = PackageData::fromArray($packageData);

        // Act: Execute the code
        $store = new PackagistStore($tile);
        $store->setPackagesData([$packageDataObject]);
        $newData = $store->getPackagesData();

        // Assert: Verify the result of the code
        $this->assertEquals(1, $newData->count());
        $newPackageDataObject = $newData->first();
        $this->assertInstanceOf(PackageData::class, $newPackageDataObject);

        $this->assertEquals($packageDataObject->getName(), $newPackageDataObject->getName());
        $this->assertEquals($packageDataObject->getDailyDownloads(), $newPackageDataObject->getDailyDownloads());
        $this->assertEquals($packageDataObject->getMonthlyDownloads(), $newPackageDataObject->getMonthlyDownloads());
        $this->assertEquals($packageDataObject->getTotalDownloads(), $newPackageDataObject->getTotalDownloads());
        $this->assertEquals($packageDataObject->getFavers(), $newPackageDataObject->getFavers());
        $this->assertEquals($packageDataObject->getGithubStars(), $newPackageDataObject->getGithubStars());
        $this->assertEquals($packageDataObject->getAbandoned(), $newPackageDataObject->getAbandoned());
    }
}
