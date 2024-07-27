<?php

namespace App\Filament\Account\Pages;

use Auth;
use Filament\Pages\Page;

class Reviews extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static string $view = 'filament.account.pages.reviews';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return Auth::user()->hasTeam();
    }

    public function mount(): void
    {
        abort_unless($this->canAccess(), 403, "You don't have a team.");
        // $this->form->fill();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Marketplace Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Reviews');
    }
}
