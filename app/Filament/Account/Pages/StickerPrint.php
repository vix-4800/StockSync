<?php

declare(strict_types=1);

namespace App\Filament\Account\Pages;

use App\Jobs\GeneratePdf;
use App\Models\GeneratedPdf;
use App\Traits\WithAccountSelection;
use Auth;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class StickerPrint extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable, WithAccountSelection;

    protected static ?string $navigationIcon = 'heroicon-o-printer';

    protected static string $view = 'filament.account.pages.sticker-print';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

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
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Generate Stickers'))
                    ->schema([
                        Select::make('generation_method')
                            ->label(__('Generation Method'))
                            ->required()
                            ->native(false)
                            ->default('by_shipment')
                            ->live()
                            ->options([
                                'by_shipment' => __('By Shipment'),
                                'by_dates' => __('By Dates'),
                            ]),
                        Select::make('shipment')
                            ->label(__('Shipment'))
                            ->requiredIf('generation_method', 'by_shipment')
                            ->options([
                                'test' => __('Test'),
                            ])
                            ->visible(fn (Get $get) => $get('generation_method') == 'by_shipment')
                            ->native(false),
                        Select::make('generation_method_by_dates')
                            ->native(false)
                            ->default('by_last_days')
                            ->live()
                            ->requiredIf('generation_method', 'by_dates')
                            ->options([
                                'by_last_days' => __('By Last Days'),
                                'by_date_period' => __('By Date Period'),
                            ])
                            ->label(__('Generation Method By Dates'))
                            ->visible(fn (Get $get) => $get('generation_method') == 'by_dates'),
                        Fieldset::make(__('By Last Days'))
                            ->visible(fn (Get $get) => $get('generation_method_by_dates') == 'by_last_days' && $get('generation_method') == 'by_dates')
                            ->schema([
                                TextInput::make('last_days')
                                    ->label(__('Last Days'))
                                    ->requiredIf('generation_method_by_dates', 'by_last_days')
                                    ->requiredIf('generation_method', 'by_dates')
                                    ->numeric()
                                    ->minValue(1)
                                    ->placeholder(__('Last Days'))
                                    ->default(30),
                            ])
                            ->columns(1),
                        Fieldset::make(__('By Date Period'))
                            ->visible(fn (Get $get) => $get('generation_method_by_dates') == 'by_date_period' && $get('generation_method') == 'by_dates')
                            ->schema([
                                DatePicker::make('start_date')
                                    ->default(now()->subDays(30))
                                    ->requiredIf('generation_method_by_dates', 'by_date_period')
                                    ->requiredIf('generation_method', 'by_dates')
                                    ->native(false)
                                    ->label(__('Start Date')),
                                DatePicker::make('end_date')
                                    ->default(now())
                                    ->label(__('End Date')),
                            ])
                            ->columns(2),
                    ])
                    ->collapsed(true)
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        if ($this->isAccountSelected()) {
            return $table
                ->query($this->getSelectedAccount()->files()->getQuery())
                ->columns([
                    TextColumn::make('supply_numbers')
                        ->sortable()
                        ->placeholder(__('Not Defined'))
                        ->searchable()
                        ->label(__('Supply Number')),
                    TextColumn::make('supply_dates')
                        ->searchable()
                        ->placeholder(__('Not Defined'))
                        ->date('Y-m-d H:i')
                        ->label(__('Supply Dates')),
                    TextColumn::make('sticker_count')
                        ->sortable()
                        ->placeholder(__('Not Defined'))
                        ->toggleable()
                        ->label(__('Stickers Count')),
                    TextColumn::make('created_at')
                        ->toggleable()
                        ->label(__('Generated At')),
                ])
                ->actions([
                    ActionGroup::make([
                        TableAction::make('download')
                            ->label(__('Download'))
                            ->icon('heroicon-o-arrow-down-tray')
                            ->color('primary')
                            ->action(fn (GeneratedPdf $record) => $record->download()),
                        TableAction::make('delete')
                            ->action(function (GeneratedPdf $record) {
                                $filePath = Storage::disk('public')->url($record->file_name);
                                if (Storage::disk('public')->exists($filePath)) {
                                    unlink($filePath);
                                }

                                $record->delete();
                            })
                            ->requiresConfirmation()
                            ->color('danger')
                            ->icon('heroicon-o-trash')
                            ->label(__('Delete')),
                    ])
                        ->tooltip(__('Actions')),
                ])
                ->toggleColumnsTriggerAction(
                    fn (TableAction $action) => $action
                        ->button()
                        ->label(__('Columns')),
                );
        }

        return $table
            ->query(GeneratedPdf::query()->limit(0))
            ->emptyStateHeading(__('Account not selected'))
            ->columns([]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('generate')
                ->submit('generate')
                ->visible(fn (): bool => $this->isAccountSelected())
                ->label(__('Generate')),
        ];
    }

    public function generate(): void
    {
        if (! $this->checkSelectedAccount()) {
            return;
        }

        $data = $this->form->getState();
        $data['marketplace_account'] = $this->getSelectedAccount();

        Notification::make()
            ->success()
            ->title(__('Generation Started'))
            ->send();

        dispatch(new GeneratePdf($this->getSelectedAccount()));
    }
}
