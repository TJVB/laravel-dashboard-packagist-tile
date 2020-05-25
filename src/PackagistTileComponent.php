<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class PackagistTileComponent extends Component
{
    use WithPagination;

    /** @var string */
    public $position;

    public $perPage;

    public function mount(string $position = 'a1', $perPage = 10)
    {
        $this->position = $position;
        $this->perPage = $perPage;
    }

    public function render()
    {
        $store = app()->make(\TJVB\PackagistTile\Contracts\PackagistStore::class);
        $packages = $this->arrangePackages($store->getPackagesData());
        $paginator = $this->getPaginator($packages);
        $view = view('dashboard-packagist-tile::tile', [
            'refreshIntervalInSeconds' => config('dashboard.tiles.packagist.refresh_interval_in_seconds', 300),
            'packages' => $packages->skip(($paginator->firstItem() ?? 1) - 1)->take($paginator->perPage()),
            'paginator' => $paginator,
        ]);
        if (config('dashboard.tiles.packagist.display.totals', true)) {
            $view->with('totals', $this->calculateTotals($packages));
        }
        return $view;
    }

    public function paginationView()
    {
        return 'dashboard-packagist-tile::pagination';
    }

    private function getPaginator(Collection $packages): LengthAwarePaginator
    {
        return new LengthAwarePaginator($packages, $packages->count(), $this->perPage, $this->page);
    }

    private function arrangePackages(Collection $packages): Collection
    {
        return $packages->when(
            !config('dashboard.tiles.packagist.with_abandoned'),
            static function ($packages) {
                return $packages->filter(static function ($package) {
                    return !$package->getAbandoned();
                });
            }
        )->when(config('dashboard.tiles.packagist.sort'), static function ($packages) {
                return $packages->sort(static function ($packageDataLeft, $packageDataRight) {
                    switch (config('dashboard.tiles.packagist.sort')) {
                        case 'name':
                            return strcasecmp($packageDataLeft->getName(), $packageDataRight->getName());
                            break;
                        case 'daily':
                            return $packageDataLeft->getDailyDownloads() - $packageDataRight->getDailyDownloads();
                            break;
                        case 'monthly':
                            return $packageDataLeft->getMonthlyDownloads() - $packageDataRight->getMonthlyDownloads();
                            break;
                        case 'total':
                            return $packageDataLeft->getTotalDownloads() - $packageDataRight->getTotalDownloads();
                            break;
                    }
                });
        })->when(config('dashboard.tiles.packagist.reverse'), static function ($packages) {
            return $packages->reverse();
        })->values();
    }

    private function calculateTotals(Collection $packages): array
    {
        return [
            'dailyDownloads' => $packages->sum(static function ($packageData) {
                return $packageData->getDailyDownloads();
            }),
            'monthlyDownloads' => $packages->sum(static function ($packageData) {
                return $packageData->getMonthlyDownloads();
            }),
            'totalDownloads' => $packages->sum(static function ($packageData) {
                return $packageData->getTotalDownloads();
            }),
            'favers' => $packages->sum(static function ($packageData) {
                return $packageData->getFavers();
            }),
            'github_stars' => $packages->sum(static function ($packageData) {
                return $packageData->getGithubStars();
            }),
        ];
    }
}
