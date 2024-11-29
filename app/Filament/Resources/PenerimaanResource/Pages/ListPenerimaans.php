<?php

namespace App\Filament\Resources\PenerimaanResource\Pages;

use App\Filament\Resources\PenerimaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenerimaans extends ListRecords
{
    protected static string $resource = PenerimaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Penerimaan'),
        ];
    }

    public function getTitle(): string
    {
        return 'Cek Data Penerimaan';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Cek Data Penerimaan';
    }
}
