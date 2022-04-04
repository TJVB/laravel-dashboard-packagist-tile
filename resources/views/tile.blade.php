<x-dashboard-tile :position="$position">
    <div class="grid grid-rows-auto-1 gap-2 h-full">
        <div class="flex items-center justify-center">
            @lang('dashboard-packagist-tile::packagisttile.Packagist data')
        </div>
        <div wire:poll.{{ $refreshIntervalInSeconds }}s class="self-center | divide-y-2">
            <table class="w-full">
                <thead class="bg-dimmed text-invers">
                <tr>
                    <th class="border p-2">@lang('dashboard-packagist-tile::packagisttile.Package')</th>
                    <th class="border p-2">@lang('dashboard-packagist-tile::packagisttile.Daily')</th>
                    <th class="border p-2">@lang('dashboard-packagist-tile::packagisttile.Monthly')</th>
                    <th class="border p-2">@lang('dashboard-packagist-tile::packagisttile.Total')</th>
                    @if(config('dashboard.tiles.packagist.display.faves'))
                        <th class="border p-2">@lang('dashboard-packagist-tile::packagisttile.Faves')</th>
                    @endif
                    @if(config('dashboard.tiles.packagist.display.github_stars'))
                        <th class="border p-2">@lang('dashboard-packagist-tile::packagisttile.GitHub stars')</th>
                    @endif
                </tr>
                </thead>
                @if(isset($totals))
                    <tr class="border-b bg-invers text-dimmed">
                        <td class="border p-2">
                            @lang('dashboard-packagist-tile::packagisttile.Totals')
                        </td>
                        <td class="border p-2">
                            {{number_format($totals['dailyDownloads'], 0, ',', '.')}}
                        </td>
                        <td class="border p-2">
                            {{number_format($totals['monthlyDownloads'], 0, ',', '.')}}
                        </td>
                        <td class="border p-2">
                            {{number_format($totals['totalDownloads'], 0, ',', '.')}}
                        </td>
                        @if(config('dashboard.tiles.packagist.display.faves'))
                            <td class="border p-2">
                                {{number_format($totals['favers'], 0, ',', '.')}}
                            </td>
                        @endif
                        @if(config('dashboard.tiles.packagist.display.github_stars'))
                            <td class="border p-2">
                                {{number_format($totals['github_stars'], 0, ',', '.')}}
                            </td>
                        @endif
                    </tr>
                @endif
                @foreach($packages as $package)
                    <tr class="@if($loop->even) bg-dimmed text-invers @endif @if($package->getAbandoned())line-through @endif">
                        <td class="border p-2">
                            <a href="https://packagist.org/packages/{{$package->getname()}}" target="_blank">{{$package->getname()}}</a>
                        </td>
                        <td class="border p-2">
                            {{number_format($package->getDailyDownloads(), 0, ',', '.')}}
                        </td>
                        <td class="border p-2">
                            {{number_format($package->getMonthlyDownloads(), 0, ',', '.')}}
                        </td>
                        <td class="border p-2">
                            {{number_format($package->getTotalDownloads(), 0, ',', '.')}}
                        </td>
                        @if(config('dashboard.tiles.packagist.display.faves'))
                            <td class="border p-2">
                                {{number_format($package->getFavers(), 0, ',', '.')}}
                            </td>
                        @endif
                        @if(config('dashboard.tiles.packagist.display.github_stars'))
                            <td class="border p-2">
                                {{number_format($package->getGithubStars(), 0, ',', '.')}}
                            </td>
                        @endif
                    </tr>
                @endforeach
                @if(isset($totals))
                    <tr class="border-b bg-invers text-dimmed">
                        <td class="border p-2">
                            @lang('dashboard-packagist-tile::packagisttile.Totals')
                        </td>
                        <td class="border p-2">
                            {{number_format($totals['dailyDownloads'], 0, ',', '.')}}
                        </td>
                        <td class="border p-2">
                            {{number_format($totals['monthlyDownloads'], 0, ',', '.')}}
                        </td>
                        <td class="border p-2">
                            {{number_format($totals['totalDownloads'], 0, ',', '.')}}
                        </td>
                        @if(config('dashboard.tiles.packagist.display.faves'))
                            <td class="border p-2">
                                {{number_format($totals['favers'], 0, ',', '.')}}
                            </td>
                        @endif
                        @if(config('dashboard.tiles.packagist.display.github_stars'))
                            <td class="border p-2">
                                {{number_format($totals['github_stars'], 0, ',', '.')}}
                            </td>
                        @endif
                    </tr>
                @endif
            </table>
            {{$paginator}}
        </div>
    </div>
</x-dashboard-tile>
