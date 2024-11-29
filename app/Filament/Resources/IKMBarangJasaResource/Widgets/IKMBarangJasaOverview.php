<?php

namespace App\Filament\Resources\IKMBarangJasaResource\Widgets;

use App\Models\IKMBarangJasa;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IKMBarangJasaOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total_Nilai_IKM = IKMBarangJasa::avg('nilai_indeks');

        return [
            Stat::make('IKM Barang dan Jasa', $total_Nilai_IKM)
            ->description('Rata-rata Nilai Indeks Barang dan Jasa.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1,2,5,10,16,20])
            ->color('success'),
            Stat::make('Total Transaksi', IKMBarangJasa::count())
            ->description('Jumlah transaksi IKM Barang dan Jasa.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1,2,5,10,16,20])
            ->color('warning'),
        ];
    }
}
