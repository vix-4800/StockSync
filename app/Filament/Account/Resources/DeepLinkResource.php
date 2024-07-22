<?php

namespace App\Filament\Account\Resources;

use App\Enums\Marketplace;
use App\Filament\Account\Resources\DeepLinkResource\Pages;
use App\Models\DeepLink;
use Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Qr\Components\Qr;

class DeepLinkResource extends Resource
{
    protected static ?string $model = DeepLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function getNavigationGroup(): ?string
    {
        return __('General Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Deep Links');
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function getEloquentQuery(): Builder
    {
        return Auth::user()
            ->deepLinks()
            ->getQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->prefixIcon('heroicon-o-tag')
                    ->prefixIconColor('primary')
                    ->minLength(4)
                    ->maxLength(125)
                    ->placeholder(__('Name'))
                    ->label(__('Name')),
                Select::make('marketplace')
                    ->required()
                    ->placeholder(__('Marketplace'))
                    ->selectablePlaceholder(false)
                    ->options([
                        Marketplace::WILDBERRIES->value => __('Wildberries'),
                        Marketplace::OZON->value => __('Ozon'),
                        Marketplace::YANDEXMARKET->value => __('Yandex Market'),
                    ])
                    ->label(__('Marketplace'))
                    ->live()
                    ->native(false),
                Qr::make('qr_code')
                    ->label(__('URL'))
                    ->optionsColumn('options')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('Name')),
                TextColumn::make('generated_url')
                    ->copyable()
                    ->limit(40)
                    ->label(__('Deep Link'))
                    ->tooltip(__('Click to copy'))
                    ->copyMessage(__('URL copied to clipboard.')),
                TextColumn::make('qr_code')
                    ->toggleable()
                    ->limit(40)
                    ->label(__('Original URL')),
                TextColumn::make('marketplace')
                    ->sortable()
                    ->badge()
                    ->color(fn (Marketplace $state): string => match ($state) {
                        Marketplace::WILDBERRIES => 'purple',
                        Marketplace::OZON => 'blue',
                        Marketplace::YANDEXMARKET => 'yellow',
                    })
                    ->label(__('Marketplace')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->label(__('Created At')),
            ])
            ->filters([])
            ->actions([
                ActionGroup::make([
                    Action::make('view_qr_code')
                        ->label(__('View QR Code'))
                        ->icon('heroicon-o-qr-code')
                        ->fillForm(fn (DeepLink $record) => [
                            'qr-data' => $record->generated_url,
                            'qr-options' => $record->options,
                        ])
                        ->form(\LaraZeus\Qr\Facades\Qr::getFormSchema('qr-data', 'qr-options'))
                        ->action(fn ($data) => dd($data)),
                    Action::make('archive')
                        ->label(__('Archive'))
                        ->requiresConfirmation()
                        ->icon('heroicon-o-archive-box')
                        ->visible(fn (DeepLink $record): bool => ! $record->isArchived())
                        ->color('danger')
                        ->action(fn (DeepLink $record) => $record->archive()),
                    Action::make('unarchive')
                        ->label(__('Unarchive'))
                        ->requiresConfirmation()
                        ->icon('heroicon-o-archive-box-x-mark')
                        ->color('warning')
                        ->visible(fn (DeepLink $record): bool => $record->isArchived())
                        ->action(fn (DeepLink $record) => $record->unarchive()),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeepLinks::route('/'),
        ];
    }
}
