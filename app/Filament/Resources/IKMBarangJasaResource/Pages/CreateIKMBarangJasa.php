<?php

namespace App\Filament\Resources\IKMBarangJasaResource\Pages;

use App\Filament\Resources\IKMBarangJasaResource;
use App\Models\IKMBarangJasa;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateIKMBarangJasa extends CreateRecord
{
    protected static string $resource = IKMBarangJasaResource::class;

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
            'nilai_indeks' => $data['nilai_indeks'],
        ];

        $IKMBarangjasaModel = new IKMBarangJasa();
        $response = $IKMBarangjasaModel->sendIKMData($sendData);

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
