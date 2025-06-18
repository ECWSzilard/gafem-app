<?php

namespace App\Filament\Resources\ExtraOptionResource\Pages;

use App\Filament\Resources\ExtraOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtraOptions extends ListRecords
{
    protected static string $resource = ExtraOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
