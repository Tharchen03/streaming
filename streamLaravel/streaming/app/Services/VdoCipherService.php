<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class VdoCipherService
{
    protected $apiSecret;
    protected $mediaServer;

    public function __construct()
    {
        $this->apiSecret = config('app.media_server_secret');
        $this->mediaServer = config('app.media_server');
    }

    public function getVideoById($videoId)
    {
        try {
            $headers = [
                "Accept" => "application/json",
                "Authorization" => "Apisecret {$this->apiSecret}",
                "Content-Type" => "application/json"
            ];

            $postData = [
                "ttl" => 300
            ];
                $postData["annotate"] = json_encode([[
                    'type' => 'rtext',
                    'text' => strtoupper('watermark'),
                    'alpha' => '0.30',
                    'color' => '0xffffff',
                    'size' => '15',
                    'interval' => '10000'
                ]]);

            $response = Http::withHeaders($headers)
                ->post("{$this->mediaServer}videos/{$videoId}/otp", $postData);

            return $response->json();
        } catch (\Exception $e) {
            Log::error("VdoCipher API Error: " . $e->getMessage());
            throw new \Exception("VdoCipher API Error: " . $e->getMessage());
        }
    }

    public function createPlaybackPolicy($videoId, $policyData)
    {
        $url = $this->mediaServer . "videos/{$videoId}/policy";

        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Apisecret " . $this->apiSecret,
            "Content-Type" => "application/json",
        ])->post($url, $policyData);

        return $response->json();
    }


    // public function getVideos()
    // {
    //     $response = $this->client->request('GET', 'https://dev.vdocipher.com/api/videos', [
    //         'headers' => [
    //             'Authorization' => 'Apisecret ' . $this->apiSecret,
    //         ]
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

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
