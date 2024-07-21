<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class UserActivities extends ListActivities
{
    protected static string $resource = UserResource::class;
}
