<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;


class PaymentService {

    public function makePaymentRequest($query){
        $graphiqlEndpoint = '';
        $response = (new Client)->post($graphiqlEndpoint,[
        'headers' => [
            'Content-Type'=> 'application/json'
        ],
        'body'=> $query
        ]);
        return $response;
    }
}