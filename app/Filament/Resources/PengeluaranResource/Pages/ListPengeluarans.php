<?php

namespace App\Filament\Resources\PengeluaranResource\Pages;

use App\Filament\Resources\PengeluaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengeluarans extends ListRecords
{
    protected static string $resource = PengeluaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Pengeluaran'),
        ];
    }

    public function getTitle(): string
    {
        return 'Cek Data Pengeluaran';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Cek Data Pengeluaran';
    }
}
