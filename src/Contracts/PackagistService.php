<?php

declare(strict_types=1);

namespace TJVB\PackagistTile\Contracts;

use TJVB\PackagistTile\PackageData;

interface PackagistService
{
    public function packagesByVendor($vendor): array;

    public function packageData($packageName): PackageData;
}
