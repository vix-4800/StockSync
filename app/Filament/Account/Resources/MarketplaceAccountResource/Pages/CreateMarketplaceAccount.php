<?php

namespace App\Filament\Account\Resources\MarketplaceAccountResource\Pages;

use App\Filament\Account\Resources\MarketplaceAccountResource;
use Auth;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreateMarketplaceAccount extends CreateRecord
{
    protected static string $resource = MarketplaceAccountResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = Auth::user()->team->id;
        $data['api_token_expires_at'] = Carbon::parse($data['api_token_created_at'])->addMonths(6);

        return $data;
    }
}
