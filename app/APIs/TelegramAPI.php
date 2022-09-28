<?php

namespace App\APIs;

use App\Utils\HttpClient;

class TelegramAPI
{
    private string $secret;

    private HttpClient $client;

    public function __construct()
    {
        $this->secret = $_ENV['TELEGRAM_BOT_SECRET'];
        $this->client = new HttpClient(
            $_ENV['TELEGRAM_API_URL'],
        );
    }

    public function sendMessage(string $text)
    {
        $response = $this->client->post("bot$this->secret/sendMessage", [
            'chat_id'       => $_ENV['TELEGRAM_CHAT_ID'],
            'parse_mode'    => 'HTML',
            'text'          => '<pre>'.$text .'</pre>'
        ]);

        if (! (isset($response['success']) && $response['success'])) {
            response($response, 500);
        }

        return $response['rates'][$cur];

    }
}