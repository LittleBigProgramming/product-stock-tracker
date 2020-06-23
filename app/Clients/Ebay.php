<?php


namespace App\Clients;


use App\Stock;

class Ebay implements Client
{

    public function checkAvailability(Stock $stock): StockCheckResponse
    {
        // TODO: Implement checkAvailability() method.
    }
}
