<?php

namespace App\APIs;

use App\Utils\HttpClient;

class CurrencyAPI
{
    public const BASE_CURRENCY = 'RUB';

    private string $secret;

    private HttpClient $client;

    public function __construct()
    {
        $this->secret = $_ENV['CURRENCY_API_SECRET'];
        $this->client = new HttpClient(
            $_ENV['CURRENCY_API_URL'],
            [
                'Content-Type'  => 'text/plain',
                'apikey'        => $this->secret
            ]
        );
    }

    public function getRateToRub($cur)
    {
        $response = $this->client->get('exchangerates_data/latest', [
            'base'      => self::BASE_CURRENCY,
            'symbols'   => $cur
        ]);

        if (! (isset($response['success']) && $response['success'])) {
            response($response, 500);
        }

        return $response['rates'][$cur];
    }
}