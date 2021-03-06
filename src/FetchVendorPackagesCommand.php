<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use TJVB\PackagistTile\Contracts\PackagistService;
use TJVB\PackagistTile\Contracts\PackagistStore;

class FetchVendorPackagesCommand extends Command
{
    protected $signature = 'dashboard:fetch-vendor-packages-from-packagist';

    protected $description = 'Fetch vendor packages for the packagist tile';

    public function handle(PackagistService $packagistService, Repository $config, PackagistStore $packagistStore): int
    {
        $this->info('Fetching vendor packages from packagist ...');
        $vendors = $config->get('dashboard.tiles.packagist.vendors', []);
        $this->output->progressStart(count($vendors));
        $vendorPackages = [];
        foreach ($vendors as $vendor) {
            $vendorPackages[] = $packagistService->packagesByVendor($vendor);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        $vendorPackages = array_merge(...$vendorPackages);

        $packagistStore->setVendorPackages($vendorPackages);

        $this->info('All done!');
        return 0;
    }
}
