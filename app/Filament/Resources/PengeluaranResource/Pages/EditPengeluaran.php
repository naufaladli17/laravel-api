<?php

namespace App\Filament\Resources\PengeluaranResource\Pages;

use App\Filament\Resources\PengeluaranResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPengeluaran extends EditRecord
{
    protected static string $resource = PengeluaranResource::class;

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
            'kd_akun' => $record->kd_akun,
            'jumlah' => $record->jumlah,
        ];
    
        $response = $record->sendPengeluaranData($data);

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
