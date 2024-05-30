<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CryptoPriceService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getCryptoPrice(string $cryptoId): ?float
    {
        $response = $this->client->request('GET', 'https://api.coingecko.com/api/v3/simple/price', [
            'query' => [
                'ids' => $cryptoId,
                'vs_currencies' => 'usd',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to retrieve crypto price');
        }

        $data = $response->toArray();

        return $data[$cryptoId]['usd'] ?? null;
    }
}
