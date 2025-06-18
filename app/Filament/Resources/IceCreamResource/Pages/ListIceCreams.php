<?php

namespace App\Filament\Resources\IceCreamResource\Pages;

use App\Filament\Resources\IceCreamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIceCreams extends ListRecords
{
    protected static string $resource = IceCreamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
