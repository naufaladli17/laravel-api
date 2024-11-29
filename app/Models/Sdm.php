<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
 
class Sdm extends Model
{
    use Sushi;

    protected $fillable = [
        'kdsatker',
        'nmsatker',
        'pns',
        'non_pns',
        'pppk',
        'tenaga_professional',
        'tgl_transaksi',
        'updated_at',
    ];

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
        $token = $this->getToken();
        
        $urlApi = 'https://training-bios2.kemenkeu.go.id/api/get/data/barang_jasa/sdm/sdm_barang_jasa';
 
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($urlApi, []);

        if ($response->successful()) {
            $check_data_sdm = $response->json();
        }

        $check_data_sdm = Arr::map($check_data_sdm['data']['datas'], function ($item) {
            return Arr::only($item, [
                'rn',
                'kdsatker',
                'nmsatker',
                'pns',
                'non_pns',
                'pppk',
                'tenaga_professional',
                'tgl_transaksi',
                'updated_at',
            ]);
        });

        return $check_data_sdm;
    }

    public function sendSdmData($data)
    {
        $token = $this->getToken();

        $urlApi = 'https://training-bios2.kemenkeu.go.id/api/ws/barang_jasa/sdm/sdm_barang_jasa';

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
