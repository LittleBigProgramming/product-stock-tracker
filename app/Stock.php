<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $fillable =
        [
            'price',
            'url',
            'sku',
            'in_stock'
        ];
}
