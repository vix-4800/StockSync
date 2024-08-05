<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\MarketplaceAccount;
use Auth;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

trait WithAccountSelection
{
    public $marketplaceAccount;

    protected Action $selectMarketplaceAccountAction;

    public function __construct()
    {
        $user = Auth::user();

        if ($user->hasTeam()) {
            $this->selectMarketplaceAccountAction = Action::make('select_account')
                ->form([
                    Select::make('account_id')
                        ->label(__('Marketplace Account'))
                        ->native(false)
                        ->default($this->marketplaceAccount)
                        ->searchable()
                        ->preload()
                        ->options([
                            __('Wildberries') => $user->team->marketplaceWildberriesAccounts->pluck('name', 'id')->toArray(),
                            __('Ozon') => $user->team->marketplaceOzonAccounts->pluck('name', 'id')->toArray(),
                        ])
                        ->required(),
                ])
                ->outlined()
                ->action(fn (array $data) => $this->marketplaceAccount = MarketplaceAccount::find($data['account_id']));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->selectMarketplaceAccountAction,
        ];
    }

    /**
     * Retrieves the action associated with the marketplace account selection.
     *
     * @return Action The action object.
     */
    public function getAccountAction(): Action
    {
        return $this->selectMarketplaceAccountAction;
    }

    /**
     * Checks if the marketplace account is selected.
     *
     * @return bool Returns true if the marketplace account is selected, false otherwise.
     */
    public function isAccountSelected(): bool
    {
        return $this->marketplaceAccount !== null;
    }

    /**
     * Checks if the selected marketplace account is valid.
     *
     * @return bool Returns true if the selected marketplace account is valid, false otherwise.
     */
    public function checkSelectedAccount(): bool
    {
        if (! $this->isAccountSelected()) {
            Notification::make()
                ->warning()
                ->title(__('Please select an account'))
                ->send();

            return false;
        }

        return true;
    }

    /**
     * Retrieves the selected marketplace account.
     *
     * @return MarketplaceAccount|null The selected marketplace account, or null if none is selected.
     */
    public function getSelectedAccount(): ?MarketplaceAccount
    {
        return $this->marketplaceAccount;
    }
}
