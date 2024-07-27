<?php

namespace App\Filament\Account\Pages;

use App\Traits\WithAccountSelection;
use Auth;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class SKUPlanner extends Page implements HasForms
{
    use InteractsWithForms, WithAccountSelection;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static string $view = 'filament.account.pages.sku-planner';

    protected static ?string $slug = 'sku-planner';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('Marketplace Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('SKU Planner');
    }

    public function getTitle(): string|Htmlable
    {
        return __('SKU Planner');
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
            Action::make('add')
                ->submit('add')
                ->label(__('Add New Note')),
        ];
    }

    public function add(): void
    {
        if (! $this->checkSelectedAccount()) {
            return;
        }

        $data = $this->form->getState();
        $data['marketplace_account'] = $this->getSelectedAccount();

        dd($data);
    }
}
