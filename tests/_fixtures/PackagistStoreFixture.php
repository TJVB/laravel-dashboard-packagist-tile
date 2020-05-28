<?php

namespace TJVB\PackagistTile\Tests\_fixtures;

use Illuminate\Support\Collection;
use TJVB\PackagistTile\Contracts\PackagistStore;

class PackagistStoreFixture implements PackagistStore
{
    public array $vendorPackages = [];
    public array $packagesData = [];

    public function setVendorPackages(array $vendorPackages): PackagistStore
    {
        $this->vendorPackages = $vendorPackages;
        return $this;
    }

    public function getVendorPackages(): array
    {
        return $this->vendorPackages;
    }

    public function setPackagesData(array $data): PackagistStore
    {
        $this->packagesData = $data;
        return $this;
    }

    public function getPackagesData(): Collection
    {
        return new Collection($this->packagesData);
    }
}
