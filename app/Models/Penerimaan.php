<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
 
class Penerimaan extends Model
{
    use Sushi;

    protected $fillable = [
        'tgl_transaksi',
        'kd_akun',
        'jumlah'
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
        $urlApi = 'https://training-bios2.kemenkeu.go.id/api/get/data/keuangan/akuntansi/penerimaan';
 
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($urlApi, [
            // Kirimkan data yang diperlukan jika ada
        ]);
        
        if ($response->successful()) {
            $check_data_penerimaan = $response->json();
        } 

        $check_data_penerimaan = Arr::map($check_data_penerimaan['data']['datas'], function ($item) {
            return [
                'rn' => (int) Arr::get($item, 'rn', 0),
                'kdsatker' => Arr::get($item, 'kdsatker', null),
                'nmsatker' => Arr::get($item, 'nmsatker', null),
                'kd_akun' => Arr::get($item, 'kd_akun', null),
                'jumlah' => (int) Arr::get($item, 'jumlah', 0),
                'tgl_transaksi' => Arr::get($item, 'tgl_transaksi', null),
                'updated_at' => Arr::get($item, 'updated_at', null),
            ];
        });

 
        return $check_data_penerimaan;
    }

    public function sendPenerimaanData($data)
    {

        $token = $this->getToken();

        $urlApi = 'https://training-bios2.kemenkeu.go.id/api/ws/keuangan/akuntansi/penerimaan';

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
