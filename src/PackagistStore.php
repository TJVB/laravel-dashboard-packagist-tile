<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Support\Collection;
use Spatie\Dashboard\Models\Tile;

class PackagistStore implements \TJVB\PackagistTile\Contracts\PackagistStore
{
    private Tile $tile;

    public function __construct(Tile $tile)
    {
        $this->tile = $tile::firstOrCreateForName('packagist');
    }

    public function setVendorPackages(array $vendorPackages): self
    {
        $this->tile->putData('vendorPackages', $vendorPackages);

        return $this;
    }

    public function getVendorPackages(): array
    {
        return $this->tile->getData('vendorPackages') ?? [];
    }

    public function setPackagesData(array $data): self
    {
        $this->tile->putData('packages', collect($data)->mapWithKeys(static function ($value, $key) {
            if ($value instanceof PackageData) {
                return [$key => $value->toArray()];
            }
            return [$key => $value];
        }));

        return $this;
    }

    public function getPackagesData(): Collection
    {
        return (new Collection($this->tile->getData('packages')))->map(static function ($packageData, $key) {
            return PackageData::fromArray($packageData);
        });
    }
}
