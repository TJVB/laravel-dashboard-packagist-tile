<?php

declare(strict_types=1);

namespace TJVB\PackagistTile;

use Illuminate\Support\Arr;

class PackageData
{
    /**
     * @var bool
     */
    private bool $abandoned;
    /**
     * @var int
     */
    private int $downloadsDaily;
    /**
     * @var int
     */
    private int $downloadsMonthly;
    /**
     * @var int
     */
    private int $downloadsTotal;
    /**
     * @var int
     */
    private int $favers;
    /**
     * @var int
     */
    private int $githubStars;
    /**
     * @var string
     */
    private string $name;

    public function __construct(
        string $name,
        int $downloadsDaily,
        int $downloadsMonthly,
        int $downloadsTotal,
        int $favers,
        int $githubStars,
        bool $abandoned
    ) {
        $this->name = $name;
        $this->downloadsDaily = $downloadsDaily;
        $this->downloadsMonthly = $downloadsMonthly;
        $this->downloadsTotal = $downloadsTotal;
        $this->favers = $favers;
        $this->abandoned = $abandoned;
        $this->githubStars = $githubStars;
    }

    public static function fromPackagistMetaData(array $data): PackageData
    {
        return new self(
            (string) Arr::get($data, 'package.name', ''),
            (int) Arr::get($data, 'package.downloads.daily', 0),
            (int) Arr::get($data, 'package.downloads.monthly', 0),
            (int) Arr::get($data, 'package.downloads.total', 0),
            (int) Arr::get($data, 'package.favers', 0),
            (int) Arr::get($data, 'package.github_stars', 0),
            (bool) Arr::get($data, 'package.abandoned', false)
        );
    }
    public static function fromArray(array $data): PackageData
    {
        return new self(
            (string) Arr::get($data, 'name', ''),
            (int) Arr::get($data, 'downloadsDaily', 0),
            (int) Arr::get($data, 'downloadsMonthly', 0),
            (int) Arr::get($data, 'downloadsTotal', 0),
            (int) Arr::get($data, 'favers', 0),
            (int) Arr::get($data, 'github_stars', 0),
            (bool) Arr::get($data, 'abandoned', true)
        );
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'downloadsDaily' => $this->downloadsDaily,
            'downloadsMonthly' => $this->downloadsMonthly,
            'downloadsTotal' => $this->downloadsTotal,
            'favers' => $this->favers,
            'github_stars' => $this->githubStars,
            'abandoned' => $this->abandoned,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDailyDownloads(): int
    {
        return $this->downloadsDaily;
    }

    public function getMonthlyDownloads(): int
    {
        return $this->downloadsMonthly;
    }

    public function getTotalDownloads(): int
    {
        return $this->downloadsTotal;
    }

    public function getFavers(): int
    {
        return $this->favers;
    }

    public function getGithubStars(): int
    {
        return $this->githubStars;
    }

    public function getAbandoned(): bool
    {
        return $this->abandoned;
    }
}
