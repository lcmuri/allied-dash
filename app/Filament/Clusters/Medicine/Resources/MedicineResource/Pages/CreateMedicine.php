<?php

namespace App\Filament\Clusters\Medicine\Resources\MedicineResource\Pages;

use App\Filament\Clusters\Medicine\Resources\MedicineResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicine extends CreateRecord
{
    protected static string $resource = MedicineResource::class;
}
