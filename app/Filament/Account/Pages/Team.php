<?php

declare(strict_types=1);

namespace App\Filament\Account\Pages;

use App\Filament\Account\Resources\EmployeeResource;
use Auth;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Throwable;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class Team extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static string $view = 'filament.account.pages.team';

    protected static ?int $navigationSort = 7;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Auth::user()->hasTeam() && Auth::user()->isManager();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Team Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Team');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Team');
    }

    public static function getEloquentQuery(): Builder
    {
        return Auth::user()->team()
            ->getQuery();
    }

    public function mount(): void
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $this->form->fill($user->team->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Main Info'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->placeholder(__('Name'))
                            ->minLength(3)
                            ->maxLength(125)
                            ->required(),
                    ]),
                Section::make(__('Contact Info'))
                    ->schema([
                        TextInput::make('email')
                            ->required()
                            ->placeholder(__('Email'))
                            ->prefixIcon('heroicon-o-envelope')
                            ->label(__('Email')),
                        PhoneInput::make('phone')
                            ->label(__('Phone'))
                            ->defaultCountry('RU')
                            ->required(),
                        TextInput::make('address')
                            ->label(__('Address'))
                            ->required()
                            ->prefixIcon('heroicon-o-map-pin')
                            ->placeholder(__('Address'))
                            ->columnSpanFull(),
                        TextInput::make('website')
                            ->label(__('Website'))
                            ->prefixIcon('heroicon-o-globe-alt')
                            ->placeholder(__('Website'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
            Action::make('employees')
                ->label(__('Manage Employees'))
                ->outlined()
                ->url(EmployeeResource::getUrl('index')),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            /** @var \App\Models\User */
            $user = Auth::user();

            $user->team->update($data);

            Notification::make()
                ->success()
                ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
                ->send();
        } catch (Throwable $exception) {
            Notification::make()
                ->danger()
                ->title(__('filament-panels::resources/pages/edit-record.notifications.failed.title'))
                ->body($exception->getMessage())
                ->send();

            return;
        }
    }
}
