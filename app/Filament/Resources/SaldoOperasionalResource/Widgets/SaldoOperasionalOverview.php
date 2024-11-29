<?php

namespace App\Filament\Resources\SaldoOperasionalResource\Widgets;

use App\Models\SaldoOperasional;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SaldoOperasionalOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total_saldo_akhir = SaldoOperasional::sum('saldo_akhir');
        return [
            Stat::make('Total Saldo Akhir', 'Rp ' . number_format($total_saldo_akhir, 0, ',', '.'))
            ->description('jumlah Saldo Operasional Akhir.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1,2,5,10,16,20])
            ->color('success'),
        ];
    }
}
