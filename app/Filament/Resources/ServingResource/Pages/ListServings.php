<?php

namespace App\Filament\Resources\ServingResource\Pages;

use App\Filament\Resources\ServingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServings extends ListRecords
{
    protected static string $resource = ServingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
