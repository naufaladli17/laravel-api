<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class SaldoOperasional extends Model
{
    use Sushi;

    protected $fillable = [
        'tgl_transaksi',
        'no_rekening',
        'unit',
        'saldo_akhir',
        'kdbank'
    ];
    /**
     * Model Rows
     *
     * @return void
     */

     public function getToken()
     {
         $urlToken = 'https://training-bios2.kemenkeu.go.id/api/token';
         
         $response = Http::post($urlToken, [
             'satker' => '620042',
             'key' => 'BuP0CfNQ5thJujcZXIWRYucw6EujPWtP',
         ]);
         
         if ($response->successful()) {
             return $response->json()['token'];
         } else {
             throw new \Exception('Gagal mendapatkan token');
         }
     }

    public function getRows()
    {
        //API
        $token = $this->getToken();
        $urlApi = 'https://training-bios2.kemenkeu.go.id/api/get/data/keuangan/saldo/saldo_operasional';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($urlApi, [
            // Kirimkan data yang diperlukan jika ada
        ]);

        if ($response->successful()) {
            $check_data_saldo = $response->json();
        }

        $check_data_saldo = Arr::map($check_data_saldo['data']['datas'], function ($item) {
            return [
                'rn' => (int) Arr::get($item, 'rn', 0),
                'kdsatker' => Arr::get($item, 'kdsatker', null),
                'nmsatker' => Arr::get($item, 'nmsatker', null),
                'no_rekening' => Arr::get($item, 'no_rekening', null),
                'unit' => Arr::get($item, 'unit', null),
                'saldo_akhir' => (int) Arr::get($item, 'saldo_akhir', 0),
                'kdbank' => Arr::get($item, 'kdbank', null),
                'tgl_transaksi' => Arr::get($item, 'tgl_transaksi', null),
                'updated_at' => Arr::get($item, 'updated_at', null),
            ];
        });

        return $check_data_saldo;
    }

    public function sendSaldoData($data)
    {

        $token = $this->getToken();

        $urlApi = 'https://training-bios2.kemenkeu.go.id/api/ws/keuangan/saldo/saldo_operasional';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($urlApi, $data);

        if ($response->successful()) {
            return $response->json();
        } else {
            return $response->throw();
        }
    }
}
