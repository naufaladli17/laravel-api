<?php

namespace App\Filament\Widgets;

use App\Models\Sdm;
use Filament\Widgets\LineChartWidget;

class ChartOverview extends LineChartWidget
{
    protected static ?string $heading = 'Chart Bar Sumber Daya Manusia';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Sumber Daya Manusia',
                    'data' => [
                        Sdm::sum('pns'),
                        Sdm::sum('non_pns'),
                        Sdm::sum('pppk'),
                        Sdm::sum('tenaga_professional'),
                    ],
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['PNS', 'NON PNS', 'PPPK', 'Tenaga Profesional'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Anda juga bisa menggunakan 'line', 'pie', dll
    }
}
