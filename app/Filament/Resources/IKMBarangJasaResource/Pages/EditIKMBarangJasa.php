<?php

namespace App\Filament\Resources\IKMBarangJasaResource\Pages;

use App\Filament\Resources\IKMBarangJasaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditIKMBarangJasa extends EditRecord
{
    protected static string $resource = IKMBarangJasaResource::class;

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
            'nilai_indeks' => $record->nilai_indeks,
        ];
    
        $response = $record->sendIKMData($data);

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
