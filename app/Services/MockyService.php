<?php 

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MockyService 
{
    /**
     * @var Client
     */
    private $client;

    public function __construct() {

        $this->client = new Client([
            'base_uri' => 'https://run.mocky.io'
        ]);
    }

    public function teste()  {
        return 'teste';
    }
    public function authorizeTransaction(): array  {
        $uri = '/v3/5794d450-d2e2-4412-8131-73d0293ac1cc';
        try {
            $response = $this->client->request('GET',$uri);
            return json_decode($response->getBody(),true);
        } catch (GuzzleException $exception) {
            return ['message' => 'Não Autorizado'];
        }
    }

    public function notifyUser(string $fakeUserId): array  {
        $uri = '/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';
        
        try {
            $response = $this->client->request($uri);
            return json_decode($response->getBody(),true);
        } catch (GuzzleException $exception) {
            return $exception->getMessage();
        }
    }

}