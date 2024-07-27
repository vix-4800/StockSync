<?php

namespace App\Filament\Account\Pages;

use Auth;
use Filament\Pages\Page;

class StickerPrint extends Page
{
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
}
