<?php

namespace App\Filament\Account\Resources;

use App\Enums\Marketplace;
use App\Filament\Account\Resources\MarketplaceAccountResource\Pages\CreateMarketplaceAccount;
use App\Filament\Account\Resources\MarketplaceAccountResource\Pages\EditMarketplaceAccount;
use App\Filament\Account\Resources\MarketplaceAccountResource\Pages\ListMarketplaceAccounts;
use App\Models\MarketplaceAccount;
use Auth;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class MarketplaceAccountResource extends Resource
{
    protected static ?string $model = MarketplaceAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function canViewAny(): bool
    {
        return Auth::user()->isManager();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Team Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Marketplace Accounts');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Marketplace Accounts');
    }

    public static function getEloquentQuery(): Builder
    {
        return Auth::user()
            ->team
            ->marketplaceAccounts()
            ->getQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->placeholder(__('Not Defined'))
                    ->maxLength(125)
                    ->required(),
                Select::make('marketplace')
                    ->label(__('Marketplace'))
                    ->selectablePlaceholder(false)
                    ->options([
                        Marketplace::WILDBERRIES->value => __('Wildberries'),
                        Marketplace::OZON->value => __('Ozon'),
                        Marketplace::YANDEXMARKET->value => __('Yandex Market'),
                    ])
                    ->live()
                    ->required()
                    ->native(false),
                Fieldset::make(__('API Credentials'))
                    ->schema([
                        Textarea::make('api_token')
                            ->label(__('API Token'))
                            ->columnSpanFull()
                            ->placeholder(__('Not Defined'))
                            ->required(),
                        TextInput::make('api_user_id')
                            ->placeholder(__('Not Defined'))
                            ->disabled(fn (Get $get): bool => $get('marketplace') !== Marketplace::OZON->value)
                            ->required(fn (Get $get): bool => $get('marketplace') === Marketplace::OZON->value)
                            ->label(__('API User ID')),
                        DatePicker::make('api_token_created_at')
                            ->default(now())
                            ->placeholder(__('Not Defined'))
                            ->live()
                            ->before(now())
                            ->native(false)
                            ->label(__('API Token Created At')),
                        Placeholder::make('api_token_expires_at')
                            ->label(__('API Token Expires At'))
                            ->hidden(fn (Get $get): bool => $get('api_token_created_at') === null)
                            ->content(
                                fn (Get $get, ?MarketplaceAccount $record): string => $record?->api_token_expires_at->format('Y-m-d') ??
                                    Carbon::parse($get('api_token_created_at'))->addMonths(6)->format('Y-m-d')
                            ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('marketplace'),
                TextColumn::make('api_token_expires_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                    ->tooltip(__('Actions')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMarketplaceAccounts::route('/'),
            'create' => CreateMarketplaceAccount::route('/create'),
            'edit' => EditMarketplaceAccount::route('/{record}/edit'),
        ];
    }
}
