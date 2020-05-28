<?php

namespace TJVB\PackagistTile\Tests\_fixtures;

use TJVB\PackagistTile\Contracts\PackagistService;
use TJVB\PackagistTile\PackageData;

class PackagistServiceFixture implements PackagistService
{
    public array $vendorPackages = [];

    public PackageData $packageData;

    public function packagesByVendor($vendor): array
    {
        return $this->vendorPackages;
    }

    public function packageData($packageName): PackageData
    {
        return $this->packageData;
    }
}
