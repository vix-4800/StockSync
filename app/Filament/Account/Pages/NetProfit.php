<?php

namespace App\Filament\Account\Pages;

use App\Traits\WithAccountSelection;
use Auth;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;

class NetProfit extends Page implements HasForms
{
    use InteractsWithForms, WithAccountSelection;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.account.pages.net-profit';

    protected static ?int $navigationSort = 5;

    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return __('General Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Net Profit Calculator');
    }

    public static function canAccess(): bool
    {
        return Auth::user()->hasTeam();
    }

    public function mount(): void
    {
        abort_unless($this->canAccess(), 403, "You don't have a team.");
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label(__('Net Profit File'))
                    ->storeFiles(false)
                    ->required()
                    ->acceptedFileTypes(['text/csv', 'application/csv', 'text/x-comma-separated-values', 'text/x-csv', 'application/vnd.ms-excel']),
                Fieldset::make('Tax')
                    ->schema([
                        Select::make('tax_rate')
                            ->native(false)
                            ->live()
                            ->options([
                                1 => '1%',
                                2 => '1+1%',
                                6 => '6%',
                                7 => '6+1%',
                                0 => __('Other'),
                            ])
                            ->default(1)
                            ->required()
                            ->label(__('Tax Rate')),
                        TextInput::make('other_tax_rate')
                            ->label(__('Other Tax Rate'))
                            ->placeholder(__('Other Tax Rate'))
                            ->disabled(fn (Get $get) => $get('tax_rate') != 0)
                            ->numeric()
                            ->hint(__('Leave empty if you don\'t want to use custom tax rate'))
                            ->requiredIf('tax_rate', 0)
                            ->validationMessages([
                                'required_if' => __('Other Tax Rate is required if Tax Rate is set to "Other"'),
                            ])
                            ->postfix('%'),
                    ]),
                Fieldset::make('Date Range')
                    ->schema([
                        DatePicker::make('start_date')
                            ->default(now())
                            ->native(false)
                            ->live()
                            ->prefix(__('From'))
                            ->placeholder(__('Start Date'))
                            ->required()
                            ->label(__('Start Date')),
                        DatePicker::make('end_date')
                            ->default(now()->addDay())
                            ->minDate('start_date')
                            ->live()
                            ->prefix(__('To'))
                            ->placeholder(__('End Date'))
                            ->required()
                            ->native(false)
                            ->label(__('End Date')),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('calculate')
                ->submit('calculate')
                ->label(__('Calculate')),
        ];
    }

    public function calculate(): void
    {
        $data = $this->form->getState();
        $data['marketplace_account'] = $this->marketplaceAccount;

        if (! $this->checkSelectedAccount()) {
            return;
        }

        dd($data);
    }
}
