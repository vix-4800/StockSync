<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;

class WildberriesTokenTypes extends Component implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    public function render()
    {
        return view('livewire.wildberries-token-types');
    }

    public function productInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'last_two_weeks_statistics_tokens' => [__('Analitics Token')],
                'generation_tokens' => [__('Content Token'), __('Marketplace Token')],
                'reviews_tokens' => [__('Questions and Reviews Token')],
                'net_profit_tokens' => [__('Statistics Token'), __('Analitics Token')],
            ])
            ->schema([
                Group::make([
                    TextEntry::make('last_two_weeks_statistics_tokens')
                        ->badge()
                        ->label(__('Last Two Weeks Statistics')),
                ]),
                Group::make([
                    TextEntry::make('generation_tokens')
                        ->badge()
                        ->label(__('Sticker Generation')),
                ]),
                Group::make([
                    TextEntry::make('reviews_tokens')
                        ->badge()
                        ->label(__('Reviews')),
                ]),
                Group::make([
                    TextEntry::make('net_profit_tokens')
                        ->badge()
                        ->label(__('Net Profit')),
                ]),
            ]);
    }
}
