<?php

namespace App\Filament\Resources\SaldoOperasionalResource\Pages;

use App\Filament\Resources\SaldoOperasionalResource;
use App\Models\SaldoOperasional;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSaldoOperasional extends CreateRecord
{
    protected static string $resource = SaldoOperasionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('sendData')
                ->label('Kirim Data ke API')
                ->action('sendDataToApi')
                ->requiresConfirmation()
                ->color('primary'),
        ];
    }

    public function sendDataToApi()
    {
        $data = $this->form->getState();

        $tgl_transaksi = $data['tgl_transaksi'];
        if ($tgl_transaksi instanceof \Carbon\Carbon) {
            $tgl_transaksi = $tgl_transaksi->format('Y-m-d');
        } elseif (is_string($tgl_transaksi)) {

            $tgl_transaksi = $tgl_transaksi;
        } else {
            $tgl_transaksi = null;
        }

        $sendData = [
            'tgl_transaksi' => $tgl_transaksi,
            'no_rekening' => $data['no_rekening'],
            'unit' => $data['unit'],
            'saldo_akhir' => $data['saldo_akhir'],
            'kdbank' => $data['kdbank'],
        ];

        $PenerimaanModel = new SaldoOperasional();
        $response = $PenerimaanModel->sendSaldoData($sendData);

        if ($response) {
            Notification::make()
                ->title('Data berhasil dikirim!')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Gagal mengirim data.')
                ->danger()
                ->send();
        }
    }
}
