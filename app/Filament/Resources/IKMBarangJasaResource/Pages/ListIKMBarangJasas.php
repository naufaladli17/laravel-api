<?php

namespace App\Filament\Resources\IKMBarangJasaResource\Pages;

use App\Filament\Resources\IKMBarangJasaResource;
use App\Models\IKMBarangJasa;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIKMBarangJasas extends ListRecords
{
    protected static string $resource = IKMBarangJasaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data IKM Barang dan Jasa'),
        ];
    }

    public function getTitle(): string
    {
        return 'Cek Data IKM Barang dan Jasa';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Cek Data IKM Barang dan Jasa';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            IKMBarangJasaResource\Widgets\IKMBarangJasaOverview::class,
        ];
    }
}
