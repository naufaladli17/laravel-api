<?php

namespace App\Filament\Resources\SdmResource\Pages;

use App\Filament\Resources\SdmResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification; // Gunakan notifikasi dari Filament

class EditSdm extends EditRecord
{
    protected static string $resource = SdmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('sendData')
                ->label('Kirim Data ke API')
                ->action('sendDataToApi')
                ->requiresConfirmation()
                ->color('primary'),
        ];
    }

    public function sendDataToApi()
    {
        $record = $this->record;

        $this->save();
    
        $record->refresh();

        $tgl_transaksi = $record->tgl_transaksi;
        if ($tgl_transaksi instanceof \Carbon\Carbon) {

            $tgl_transaksi = $tgl_transaksi->format('Y-m-d');
        } elseif (is_string($tgl_transaksi)) {

            $tgl_transaksi = $tgl_transaksi; 
        } else {
            $tgl_transaksi = null;
        }
    
        $data = [
            'tgl_transaksi' => $tgl_transaksi,
            'pns' => (int) $record->pns,
            'non_pns' => (int) $record->non_pns,
            'pppk' => (int) $record->pppk,
            'tenaga_professional' => (int) $record->tenaga_professional,
        ];
    
        $response = $record->sendSdmData($data);
        // Tampilkan notifikasi sukses atau gagal
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
