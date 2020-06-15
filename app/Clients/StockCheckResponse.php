<?php


namespace App\Clients;


class StockCheckResponse
{
    public $available;
    public $price;

    /**
     * StockCheckResponse constructor.
     * @param $available
     * @param $price
     */
    public function __construct($available, $price)
    {
        $this->available = $available;
        $this->price = $price;
    }
}
