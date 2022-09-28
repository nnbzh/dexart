<?php

namespace App\Controllers;

use App\Services\CurrencyService;
use Core\Request;

class CurrencyController
{
    public function get(Request $request)
    {
        if (! $request->currency) {
            response(["message" => "Parameter 'currency' not set!"], 422);
        }

        $service = new CurrencyService;

        response($service->getCurrencyRate($request->currency));
    }
}