<?php

namespace App\Filament\Resources\SdmResource\Pages;

use App\Filament\Resources\SdmResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSdm extends ViewRecord
{
    protected static string $resource = SdmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
