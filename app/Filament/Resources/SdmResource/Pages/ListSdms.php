<?php

namespace App\Filament\Resources\SdmResource\Pages;

use App\Filament\Resources\SdmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSdms extends ListRecords
{
    protected static string $resource = SdmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Sumber Daya Manusia'),
        ];
    }

    public function getTitle(): string
    {
        return 'Cek Data Sumber Daya Manusia';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Cek Data Sumber Daya Manusia';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SdmResource\Widgets\SdmOverview::class,
        ];
    }
}
