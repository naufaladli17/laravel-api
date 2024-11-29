<?

namespace App\Services;

use GuzzleHttp\Client;

class ApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getToken()
    {
        try {
            $response = $this->client->post('https://training-bios2.kemenkeu.go.id/api/token', [
                'form_params' => [
                    'satker' => '620042',
                    'key' => 'BuP0CfNQ5thJujcZXIWRYucw6EujPWtP',
                ]
            ]);
    
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true)['token'];
            } else {
                // Jika status code tidak 200, berikan informasi tentang error
                return 'Error: Unexpected response status ' . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    

    public function sendSdmData($token, $data)
    {
        $response = $this->client->post('https://training-bios2.kemenkeu.go.id/api/ws/barang_jasa/sdm/sdm_barang_jasa', [
            'headers' => [
                'token' => $token,
            ],
            'form_params' => $data
        ]);
        
        return json_decode($response->getBody()->getContents(), true);
    }

    public function checkSdmData($token)
    {
        $response = $this->client->post('https://training-bios2.kemenkeu.go.id/api/get/data/barang_jasa/sdm/sdm_barang_jasa', [
            'headers' => [
                'token' => $token,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
