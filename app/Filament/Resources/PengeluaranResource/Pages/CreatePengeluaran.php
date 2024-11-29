<?php

namespace App\Filament\Resources\PengeluaranResource\Pages;

use App\Filament\Resources\PengeluaranResource;
use App\Models\Pengeluaran;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePengeluaran extends CreateRecord
{
    protected static string $resource = PengeluaranResource::class;

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
            'kd_akun' => $data['kd_akun'],
            'jumlah' => $data['jumlah'],
        ];

        $PenerimaanModel = new Pengeluaran();
        $response = $PenerimaanModel->sendPengeluaranData($sendData);

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
