<?php

declare(strict_types=1);

namespace TJVB\PackagistTile\Contracts;

use Illuminate\Support\Collection;

interface PackagistStore
{
    public function setVendorPackages(array $vendorPackages): self;

    public function getVendorPackages(): array;

    public function setPackagesData(array $data): self;

    public function getPackagesData(): Collection;
}
