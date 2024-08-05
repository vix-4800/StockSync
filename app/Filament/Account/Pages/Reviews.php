<?php

declare(strict_types=1);

namespace App\Filament\Account\Pages;

use App\Traits\WithAccountSelection;
use Auth;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;

class Reviews extends Page implements HasForms
{
    use InteractsWithForms, WithAccountSelection;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static string $view = 'filament.account.pages.reviews';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

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
