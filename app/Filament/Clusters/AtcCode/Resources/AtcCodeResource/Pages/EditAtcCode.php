<?php

namespace App\Filament\Clusters\AtcCode\Resources\AtcCodeResource\Pages;

use App\Filament\Clusters\AtcCode\Resources\AtcCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAtcCode extends EditRecord
{
    protected static string $resource = AtcCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
