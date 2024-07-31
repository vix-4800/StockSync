<?php

namespace App\Filament\Account\Widgets;

use App\Services\WildberriesApiService;
use Auth;
use DateInterval;
use DateTime;
use Filament\Widgets\ChartWidget;

class WildberriesSalesChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $to = new DateTime;
        $interval = DateInterval::createFromDateString(13 .' days');
        $from = (clone $to)->sub($interval);
        $from->setTime(0, 0, 0);

        if (Auth::user()->hasTeam()) {
            $service = new WildberriesApiService(Auth::user()->team->marketplaceWildberriesAccounts->first());
            $data = $service->getSellerStatistics($from, $to)->getData();

            if (empty($data)) {
                return [];
            }
        }

        return [
            'datasets' => [],
            'labels' => [],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
