<?php

namespace App\Services;

use GuzzleHttp\Client;

class VdoCipherService
{
    protected $client;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('VDOCIPHER_API_KEY');
        $this->apiSecret = env('VDOCIPHER_API_SECRET');
    }

    public function getVideos()
    {
        $response = $this->client->request('GET', 'https://dev.vdocipher.com/api/videos', [
            'headers' => [
                'Authorization' => 'Apisecret ' . $this->apiSecret,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    // public function uploadVideo($filePath)
    // {
    //     $response = $this->client->request('POST', 'https://dev.vdocipher.com/api/videos', [
    //         'headers' => [
    //             'Authorization' => 'Apisecret ' . $this->apiSecret,
    //         ],
    //         'multipart' => [
    //             [
    //                 'name'     => 'file',
    //                 'contents' => fopen($filePath, 'r'),
    //             ],
    //         ],
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }
}
