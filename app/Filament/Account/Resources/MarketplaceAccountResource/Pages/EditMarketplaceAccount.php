<?php

namespace App\Filament\Account\Resources\MarketplaceAccountResource\Pages;

use App\Filament\Account\Resources\MarketplaceAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketplaceAccount extends EditRecord
{
    protected static string $resource = MarketplaceAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
