<?php

namespace App\Services;

use App\Utils\HttpClient;

class CurrencyService
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
        [$response, $code] = $this->client->get('exchangerates_data/latest', [
            'base'      => self::BASE_CURRENCY,
            'symbols'   => $cur
        ]);

        if (! (isset($response['success']) && $response['success'])) {
            response($response, $code);
        }

        return $response;
    }
}