<?php

namespace App\Filament\Account\Resources\DeepLinkResource\Pages;

use App\Enums\Marketplace;
use App\Filament\Account\Resources\DeepLinkResource;
use App\Models\DeepLink;
use Auth;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Str;

class ListDeepLinks extends ListRecords
{
    protected static string $resource = DeepLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->using(function (array $data) {
                    $marketplace = match ($data['marketplace']) {
                        Marketplace::WILDBERRIES->value => 'wb',
                        Marketplace::OZON->value => 'ozon',
                        Marketplace::YANDEXMARKET->value => 'yandex',
                    };

                    $data['user_id'] = Auth::id();
                    $data['generated_url'] = env('DEEP_LINKS_URL').$marketplace.'/'.Str::random(15).'/';

                    return DeepLink::create($data);
                }),
        ];
    }

    public function getTabs(): array
    {
        return [
            __('Unarchived') => Tab::make()
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('is_archived', false)),
            __('Archived') => Tab::make()
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('is_archived', true)),
        ];
    }
}
