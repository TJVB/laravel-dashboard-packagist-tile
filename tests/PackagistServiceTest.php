<?php

namespace TJVB\PackagistTile\Tests;

use Spatie\Packagist\PackagistClient;
use TJVB\PackagistTile\PackageData;
use TJVB\PackagistTile\PackagistService;

class PackagistServiceTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function weCanHandleThatWeDontGetVendorDataFromPackagist(): void
    {
        // Arrange: create dependencies and test doubles
        $packagistClientMock = $this->mock(PackagistClient::class);
        $packagistClientMock->shouldReceive('getPackagesNamesByVendor')
            ->andReturnNull();

        // Act: Execute the code
        $service = new PackagistService($packagistClientMock);
        $packages = $service->packagesByVendor('tjvb');

        // Assert: Verify the result of the code
        $this->assertIsArray($packages);
        $this->assertCount(0, $packages);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weCanHandleThatWeGetDataWithoutThePackageNamesFromPackagist(): void
    {
        // Arrange: create dependencies and test doubles
        $packagistClientMock = $this->mock(PackagistClient::class);
        $packagistClientMock->shouldReceive('getPackagesNamesByVendor')
            ->andReturn(['something' => 'else']);

        // Act: Execute the code
        $service = new PackagistService($packagistClientMock);
        $packages = $service->packagesByVendor('tjvb');

        // Assert: Verify the result of the code
        $this->assertIsArray($packages);
        $this->assertCount(0, $packages);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weCanGetThePackagesDataFromPackagist(): void
    {
        // Arrange: create dependencies and test doubles
        $packages = [
            'tjvb/laravel-dashboard-packagist-tile',
            'tjvb/laravel-mail-catchall',
        ];
        $packagistClientMock = $this->mock(PackagistClient::class);
        $packagistClientMock->shouldReceive('getPackagesNamesByVendor')
            ->andReturn(['packageNames' => $packages]);

        // Act: Execute the code
        $service = new PackagistService($packagistClientMock);
        $foundPackages = $service->packagesByVendor('tjvb');

        // Assert: Verify the result of the code
        $this->assertEquals($packages, $foundPackages);
    }

    /**
     * @return void
     *
     * @test
     */
    public function weCanGetThePackageDatFromPackagist(): void
    {
        // Arrange: create dependencies and test doubles
        $packagistdata = json_decode(file_get_contents(self::FIXTURES_PATH . 'packagistMetaData.json'), true);
        $packagistClientMock = $this->mock(PackagistClient::class);
        $packagistClientMock->shouldReceive('getPackage')
            ->andReturn($packagistdata);

        // Act: Execute the code
        $service = new PackagistService($packagistClientMock);
        $packageData = $service->packageData('tjvb/laravel-mail-catchall');

        // Assert: Verify the result of the code
        $this->assertInstanceOf(PackageData::class, $packageData);
        $this->assertEquals('tjvb/laravel-mail-catchall', $packageData->getName());
    }
}
