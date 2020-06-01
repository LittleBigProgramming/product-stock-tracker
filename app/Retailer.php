<?php

namespace App;

class Retailer extends Model
{
    protected $fillable = ['name'];

    public function addStock(Product $product, Stock $stock)
    {   $stock->product_id = $product->id;

        $this->stock()->save($stock);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
