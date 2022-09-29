<?php

namespace App\Controllers;

use App\DTOs\CurrencyRequestDTO;
use App\Services\CurrencyService;
use Core\Request;

class CurrencyController
{
    public function get(Request $request)
    {
        if (! $request->currency) {
            response(["message" => "Parameter 'currency' not set!"], 422);
        }

        $data    = new CurrencyRequestDTO($request->currency);
        $service = new CurrencyService;

        response($service->getCurrencyRate($data));
    }
}