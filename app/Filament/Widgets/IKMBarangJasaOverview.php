<?php

namespace App\Filament\Widgets;

use App\Models\IKMBarangJasa;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;

class IKMBarangJasaOverview extends LineChartWidget
{
    protected static ?string $heading = 'Grafik Indeks Kepuasan Masyarakat';

    protected static ?int $sort = 2;

    protected function getFilters(): ?array
    {
        return [
            'daily' => 'Per Hari',
            'monthly' => 'Per Bulan',
            'yearly' => 'Per Tahun',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'daily'; // Default ke Per Hari
        $ikmData = IKMBarangJasa::orderBy('tgl_transaksi', 'asc')->get();

        $labels = [];
        $nilaiIndeks = [];

        if ($filter === 'daily') {
            // Per Hari
            $filteredData = $ikmData->take(-8); // Ambil 8 data terakhir
            foreach ($filteredData as $item) {
                $labels[] = Carbon::parse($item->tgl_transaksi)->format('Y-m-d');
                $nilaiIndeks[] = $item->nilai_indeks;
            }
        } elseif ($filter === 'monthly') {
            // Per Bulan
            $groupedByMonth = $ikmData->groupBy(function ($item) {
                return Carbon::parse($item->tgl_transaksi)->format('Y-m'); // Format: Tahun-Bulan
            });

            $groupedByMonth = $groupedByMonth->take(-8); // Ambil 8 data terakhir
            foreach ($groupedByMonth as $month => $items) {
                $labels[] = Carbon::parse($month . '-01')->format('F Y'); // Nama bulan
                $nilaiIndeks[] = $items->avg('nilai_indeks'); // Ambil rata-rata per bulan
            }
        } elseif ($filter === 'yearly') {
            // Per Tahun
            $groupedByYear = $ikmData->groupBy(function ($item) {
                return Carbon::parse($item->tgl_transaksi)->format('Y'); // Format: Tahun
            });

            $groupedByYear = $groupedByYear->take(-8); // Ambil 8 data terakhir
            foreach ($groupedByYear as $year => $items) {
                $labels[] = $year;
                $nilaiIndeks[] = $items->avg('nilai_indeks'); // Ambil rata-rata per tahun
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Nilai Indeks Kepuasan Masyarakat',
                    'backgroundColor' => '#FFA500',
                    'borderColor' => '#FFA500',
                    'fill' => false,
                    'tension' => 0.3,
                    'data' => $nilaiIndeks,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Jenis chart: Line chart
    }
}
