<?php

namespace App\Filament\Account\Pages;

use App\Traits\WithAccountSelection;
use Auth;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;

class StickerPrint extends Page implements HasForms
{
    use InteractsWithForms, WithAccountSelection;

    protected static ?string $navigationIcon = 'heroicon-o-printer';

    protected static string $view = 'filament.account.pages.sticker-print';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Marketplace Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Sticker Print');
    }

    public static function canAccess(): bool
    {
        return Auth::user()->hasTeam();
    }

    public function mount(): void
    {
        abort_unless($this->canAccess(), 403, "You don't have a team.");
        // $this->form->fill();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('generate')
                ->submit('generate')
                ->label(__('Generate')),
        ];
    }

    public function generate(): void
    {
        $data = $this->form->getState();
        $data['marketplace_account'] = $this->marketplaceAccount;

        if (! $this->checkSelectedAccount()) {
            return;
        }

        dd($data);
    }
}
