<?php

namespace App\Filament\Widgets;

use App\Models\IKMBarangJasa;
use App\Models\SaldoOperasional;
use App\Models\Sdm;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PanelOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {

        $total_Nilai_IKM = IKMBarangJasa::avg('nilai_indeks');
        $total_saldo_akhir = SaldoOperasional::sum('saldo_akhir');
        $total_sdm_pns = Sdm::sum('pns');
        $total_sdm_non_pns = Sdm::sum('non_pns');
        $total_sdm_pppk = Sdm::sum('pppk');
        $total_sdm_tenaga_professional = Sdm::sum('tenaga_professional');
        $total_sdm = $total_sdm_pns + $total_sdm_non_pns + $total_sdm_pppk + $total_sdm_tenaga_professional;

        return [        
            Stat::make('Total Sumber Daya Manusia', $total_sdm)
            ->description('Jumlah sumber daya manusia.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1,2,5,10,16,20])
            ->color('info'),
            Stat::make('Indeks Kepuasan Masyarakat', $total_Nilai_IKM)
            ->description('Rata-rata Nilai Indeks Kepuasan Masyarakat.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1,2,5,10,16,20])
            ->color('warning'),
            Stat::make('Total Saldo Operasional', 'Rp ' . number_format($total_saldo_akhir, 0, ',', '.'))
            ->description('jumlah Saldo Operasional Akhir.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1,2,5,10,16,20])
            ->color('success'),
        ];
    }
}
