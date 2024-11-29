<?php

namespace App\Filament\Resources\SdmResource\Widgets;

use App\Models\Sdm;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SdmOverview extends BaseWidget
{
    protected function getStats(): array
    {
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
            Stat::make('Total Transaksi', Sdm::count())
            ->description('Jumlah transaksi sumber daya manusia.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1,2,5,10,16,20])
            ->color('warning'),
        ];
    }
}
