<?php

namespace App\DTOs;

class CurrencyRequestDTO
{
    public string $currency;

    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }
}