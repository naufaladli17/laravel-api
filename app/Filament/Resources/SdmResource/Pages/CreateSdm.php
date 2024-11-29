<?php

namespace App\Filament\Resources\SdmResource\Pages;

use App\Models\Sdm;
use App\Filament\Resources\SdmResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSdm extends CreateRecord
{
    protected static string $resource = SdmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('sendData')
                ->label('Kirim Data ke API')
                ->action('sendDataToApi') // Nama fungsi yang akan dijalankan
                ->requiresConfirmation() // Konfirmasi sebelum mengirim data
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
            'pns' => (int) $data['pns'],
            'non_pns' => (int) $data['non_pns'],
            'pppk' => (int) $data['pppk'],
            'tenaga_professional' => (int) $data['tenaga_professional'],
        ];

        $sdmModel = new Sdm();
        $response = $sdmModel->sendSdmData($sendData);

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
