<?php

namespace App\Filament\Resources\SaldoOperasionalResource\Pages;

use App\Filament\Resources\SaldoOperasionalResource;
use App\Models\SaldoOperasional;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaldoOperasionals extends ListRecords
{
    protected static string $resource = SaldoOperasionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Saldo Operasional'),
        ];
    }

    public function getTitle(): string
    {
        return 'Cek Data Saldo Operasional';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Cek Data Saldo Operasional';
    }

    
    protected function getHeaderWidgets(): array
    {
        return [
            SaldoOperasionalResource\Widgets\SaldoOperasionalOverview::class,
        ];
    }
}
