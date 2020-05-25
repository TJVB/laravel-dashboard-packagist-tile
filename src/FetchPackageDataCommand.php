<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class FetchPackageDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-package-data-from-packagist';

    protected $description = 'Fetch package data for the packagist tile';

    public function handle(PackagistService $packagistService, Repository $config): int
    {
        $this->info('Fetching Package data from packagist ...');

        $packages = array_merge(
            $config->get('dashboard.tiles.packagist.packages', []),
            PackagistStore::make()->getVendorPackages()
        );
        $this->output->progressStart(count($packages));
        $packageData = [];
        foreach ($packages as $package) {
            $packageData[$package] = $packagistService->packageData($package);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        PackagistStore::make()->setPackagesData($packageData);

        $this->info('All done!');
        return 0;
    }
}
