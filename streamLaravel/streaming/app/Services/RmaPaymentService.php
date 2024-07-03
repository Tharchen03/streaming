<?php

namespace App\Services;
use GuzzleHttp\Client;


class RmaPaymentService {

    public function makePaymentRequest($query){
        // $graphiqlEndpoint = 'https://payment.educareskill.com/pg';
        $graphiqlEndpoint = 'http://10.10.10.227:8000/graphql';
        $response = (new Client)->post($graphiqlEndpoint,[
        'headers' => [
            'Content-Type'=> 'application/json'
        ],
        'body'=> json_encode(['query'=>$query])
        ]);
        return $response;
    }
}
