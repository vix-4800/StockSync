<?php

declare(strict_types=1);

namespace App\Filament\Account\Resources\MarketplaceAccountResource\Pages;

use App\Filament\Account\Resources\MarketplaceAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketplaceAccounts extends ListRecords
{
    protected static string $resource = MarketplaceAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
