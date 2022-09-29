<?php

namespace App\Services;

use App\APIs\CurrencyAPI;
use App\APIs\TelegramAPI;
use App\DTOs\CurrencyRequestDTO;
use App\DTOs\CurrencyResponseDTO;
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

    public function getCurrencyRate(CurrencyRequestDTO $data): CurrencyResponseDTO
    {
        $rate = $this->currencyApi->getRateToRub($data->currency);
        $this->telegramApi->sendMessage(
            "Курс $data->currency к 1 ".CurrencyAPI::BASE_CURRENCY." на "
            .date('d.m.Y', strtotime(date('d.m.Y'))).
            " составил:$rate");

        return new CurrencyResponseDTO(CurrencyAPI::BASE_CURRENCY, $data->currency, $rate);
    }
}