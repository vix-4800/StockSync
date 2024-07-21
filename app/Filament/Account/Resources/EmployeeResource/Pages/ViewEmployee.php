<?php

declare(strict_types=1);

namespace App\Filament\Account\Resources\EmployeeResource\Pages;

use App\Filament\Account\Resources\EmployeeResource;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;
}
