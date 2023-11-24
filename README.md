# Show packagist downloads in a tile on Spatie Laravel downloads


[![Latest Stable Version](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/v)](https://packagist.org/packages/tjvb/laravel-dashboard-packagist-tile)
[![Pipeline status](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/badges/master/pipeline.svg)](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/-/pipelines?page=1&scope=all&ref=master)
[![Coverage report](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/badges/master/coverage.svg)](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/-/pipelines?page=1&scope=all&ref=master)
[![Tested on PHP 7.4 to 8.3](https://img.shields.io/badge/Tested%20on-PHP%207.4%20|%208.0%20|%208.1%20|%208.2%20|%208.3-brightgreen.svg?maxAge=2419200)](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/-/pipelines?page=1&scope=all&ref=master)
[![Tested on Laravel 9 to 10](https://img.shields.io/badge/Tested%20on-Laravel%207%20|%208%20|%209%20|%2010-brightgreen.svg?maxAge=2419200)](https://gitlab.com/tjvb/laravel-mail-catchall/-/pipelines?page=1&scope=all&ref=master)
[![Latest Unstable Version](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/v/unstable)](https://packagist.org/packages/tjvb/laravel-dashboard-packagist-tile)


[![PHP Version Require](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/require/php)](https://packagist.org/packages/tjvb/laravel-dashboard-packagist-tile)
[![Laravel Version Require](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/require/illuminate/support)](https://packagist.org/packages/tjvb/laravel-mail-catchall)
[![Livewire Version Require](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/require/livewire/livewire)](https://packagist.org/packages/tjvb/laravel-mail-catchall)
[![PHPMD](https://img.shields.io/badge/PHPMD-checked-brightgreen.svg)](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/-/blob/master/phpmd.xml.dist)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg)](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/-/blob/master/phpcs.xml.dist)


[![License](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/license)](https://packagist.org/packages/tjvb/laravel-dashboard-packagist-tile)


![Packagist data tile screenshot](/docs/images/packagist-data-screenshot.jpg)

This tile can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard) to show packagist statistics about the package you like to see. You can hide abandoned package and the totals for the packages. It also support pagination.

## Installation

You can install the package via composer:

```bash
composer require tjvb/laravel-dashboard-packagist-tile
```

In the `dashboard` config file, you must add this configuration in the `tiles` key. And customize it for your own needs.
```php
// in config/dashboard.php

return [

    'tiles' => [
        'packagist' => [
            'refresh_interval_in_seconds' => 300,
            'sort' => 'total', // options: name, daily, monthly, total, empty means no sorting.
            'reverse' => true, // reverse the order
            'with_abandoned' => true, // set to false to ignore them
            'display' => [
                'totals' => true,
                'faves' => true, // packagist faces
                'github_stars' => true, // github stars
            ],
            'vendors' => [ // vendors from which you want to see all the packages
                'tjvb',
                'spatie',
            ],
            'packages' => [ // specific packages that you want to see.
                'phpmd/phpmd',
                'pdepend/pdepend',
            ],
        ],
    ],
];


```

To load the data from packagist there are two commands to schedule. The FetchPackageDataCommand gets the statistics for the package. This is cached for twelve hours so it isn't usefull to get it more then twice a day. See the [Packagist API documentation](https://packagist.org/apidoc#get-package-data)  

The second command is to get the packages for the vendors that you have configured. If you create a lot of packages like the great people from [Spatie](https://spatie.be/) it can be usefull to automate it. Else it is preferable to run `php artisan dashboard:fetch-vendor-packages-from-packagist` after you publish a new package on packagist. 

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(\TJVB\PackagistTile\FetchPackageDataCommand::class)->twiceDaily();
    // Additional if the vendors you watch release a lot of packages.
    // Else be nice and do it manually with php artisan dashboard:fetch-vendor-packages-from-packagist.
    // $schedule->command(\TJVB\PackagistTile\FetchVendorPackagesCommand::class)->daily();
}
```

## Usage

In your dashboard view you use the `livewire:packagist-tile` component.

```html
<x-dashboard>
    <livewire:packagist-tile position="e7:e16" />
</x-dashboard>
```

## Pagination
The packages are paginated, by default a page has a maximum of 10 packages. This can be changed with adding a perPage property to the  tile.
```html
<x-dashboard>
    <livewire:packagist-tile position="e7:e16" perPage="2" />
</x-dashboard>
```

## Customizing the view

If you want to customize the view used to render this tile, run this command:

```bash
php artisan vendor:publish --provider="TJVB\PackagistTile\PackagistTileServiceProvider" --tag="dashboard-packagist-views"
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email info@tjvb.nl instead of using the issue tracker.


## Credits

- [Tobias van Beek](https://tjvb.nl/about)
- [All Contributors](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/-/graphs/master)

## Thanks to
- [Spatie](https://docs.spatie.be) for the [dashboard](https://github.com/spatie/laravel-dashboard) and [packagist api package](https://github.com/spatie/packagist-api).
- [Packagist](https://packagist.org/) for the great service.
- [Frontend preset for Tailwind CSS](https://github.com/laravel-frontend-presets/tailwindcss) For the pagination preset.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
