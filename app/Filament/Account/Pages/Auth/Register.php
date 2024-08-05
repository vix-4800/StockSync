<?php

declare(strict_types=1);

namespace App\Filament\Account\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Register as BaseRegister;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneNumberFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getPhoneNumberFormComponent(): Component
    {
        return PhoneInput::make('phone')
            ->required()
            ->label(__('Phone'));
    }
}
