<?php


namespace App\Clients;


use App\Stock;
use Illuminate\Support\Facades\Http;

class Amazon implements Client
{

    /**
     * @param Stock $stock
     * @return StockCheckResponse
     */
    public function checkAvailability(Stock $stock): StockCheckResponse
    {
        $results = Http::get('https://foo.test')->json();

        return new StockCheckResponse(
            $results['available'],
            $results['price']
        );
    }
}
