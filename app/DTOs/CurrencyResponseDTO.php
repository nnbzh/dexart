<?php

namespace App\DTOs;

class CurrencyResponseDTO
{
    public string $base;

    public string $incoming;

    public string $rate;

    public function __construct(string $baseCurrency, string $incomingCurrency, string $rate)
    {
        $this->base     = $baseCurrency;
        $this->incoming = $incomingCurrency;
        $this->rate     = $rate;
    }
}