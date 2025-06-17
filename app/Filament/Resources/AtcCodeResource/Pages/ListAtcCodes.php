<?php

namespace App\Filament\Resources\AtcCodeResource\Pages;

use App\Filament\Resources\AtcCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAtcCodes extends ListRecords
{
    protected static string $resource = AtcCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
