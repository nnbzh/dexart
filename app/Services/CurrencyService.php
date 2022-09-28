<?php

namespace App\Services;

use App\APIs\CurrencyAPI;
use App\APIs\TelegramAPI;
use App\Utils\HttpClient;

class CurrencyService
{
    private CurrencyAPI $currencyApi;
    private TelegramAPI $telegramApi;

    public function __construct()
    {
        $this->currencyApi = new CurrencyAPI;
        $this->telegramApi = new TelegramAPI;
    }

    public function getCurrencyRate(string $currency)
    {
        $rate = $this->currencyApi->getRateToRub($currency);
        $this->telegramApi->sendMessage(
            "Курс $currency к 1 ".CurrencyAPI::BASE_CURRENCY." на "
            .date('d.m.Y', strtotime(date('d.m.Y'))).
            " составил:$rate");

        return [];
    }
}