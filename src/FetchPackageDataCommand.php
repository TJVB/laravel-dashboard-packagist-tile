<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use TJVB\PackagistTile\Contracts\PackagistService;
use TJVB\PackagistTile\Contracts\PackagistStore;

class FetchPackageDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-package-data-from-packagist';

    protected $description = 'Fetch package data for the packagist tile';

    public function handle(PackagistService $packagistService, Repository $config, PackagistStore $packagistStore): int
    {
        $this->info('Fetching package data from packagist ...');

        $packages = array_merge(
            $config->get('dashboard.tiles.packagist.packages', []),
            $packagistStore->getVendorPackages()
        );
        $this->output->progressStart(count($packages));
        $packageData = [];
        foreach ($packages as $package) {
            $packageData[] = $packagistService->packageData($package);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        $packagistStore->setPackagesData($packageData);

        $this->info('All done!');
        return 0;
    }
}
