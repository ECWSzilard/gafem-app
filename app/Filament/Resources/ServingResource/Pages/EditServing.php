<?php

namespace App\Filament\Resources\ServingResource\Pages;

use App\Filament\Resources\ServingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServing extends EditRecord
{
    protected static string $resource = ServingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
