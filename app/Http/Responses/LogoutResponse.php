<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as Responsable;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements Responsable
{
    public function toResponse($request): RedirectResponse
    {
        return to_route('filament.account.auth.login');
    }
}
