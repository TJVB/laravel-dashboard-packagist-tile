# Show packagist downloads in a tile on Spatie Laravel downloads

[![Latest Stable Version](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/v/stable)](https://packagist.org/packages/tjvb/laravel-dashboard-packagist-tile)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/tjvb/laravel-dashboard-packagist-tile.svg?style=flat-square)](https://packagist.org/packages/tjvb/laravel-dashboard-packagist-tile)
[![pipeline status](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/badges/master/pipeline.svg)](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/commits/master)
[![coverage report](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/badges/master/coverage.svg)](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/commits/master)
[![License](https://poser.pugx.org/tjvb/laravel-dashboard-packagist-tile/license)](https://packagist.org/packages/tjvb/laravel-dashboard-packagist-tile)


A friendly explanation of what your tile does.

![Packagist data tile screenshot](./docs/images/packagist-data-screenshot/jpg)

This tile can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard) to show packagist statistics about the package you like to see.

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

- [Tobias van Beek](https://github.com/tvbeek)
- [All Contributors](https://gitlab.com/tjvb/laravel-dashboard-packagist-tile/-/graphs/master)

## Thanks to
- [Spatie](https://docs.spatie.be) for the [dashboard](https://github.com/spatie/laravel-dashboard) and [packagist api package](https://github.com/spatie/packagist-api).
- [Packagist](https://packagist.org/) for the great service.
- [Frontend preset for Tailwind CSS](https://github.com/laravel-frontend-presets/tailwindcss) For the pagination preset.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
