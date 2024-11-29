<?php

namespace App\Filament\Resources\IKMBarangJasaResource\Pages;

use App\Filament\Resources\IKMBarangJasaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIKMBarangJasa extends ViewRecord
{
    protected static string $resource = IKMBarangJasaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
