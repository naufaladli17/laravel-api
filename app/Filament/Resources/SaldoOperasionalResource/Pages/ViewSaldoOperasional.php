<?php

namespace App\Filament\Resources\SaldoOperasionalResource\Pages;

use App\Filament\Resources\SaldoOperasionalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSaldoOperasional extends ViewRecord
{
    protected static string $resource = SaldoOperasionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
