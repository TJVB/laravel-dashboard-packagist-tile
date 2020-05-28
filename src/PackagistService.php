<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Support\Arr;
use Spatie\Packagist\PackagistClient;

class PackagistService implements \TJVB\PackagistTile\Contracts\PackagistService
{
    /**
     * @var PackagistClient
     */
    private $packagist;

    public function __construct(PackagistClient $packagist)
    {
        $this->packagist = $packagist;
    }

    public function packagesByVendor($vendor): array
    {
        return Arr::get($this->packagist->getPackagesNamesByVendor($vendor) ?? [], 'packageNames', []);
    }

    public function packageData($packageName): PackageData
    {
        return PackageData::fromPackagistMetaData($this->packagist->getPackage($packageName));
    }
}
