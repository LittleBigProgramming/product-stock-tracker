<?php

namespace App;


use Facades\App\Clients\ClientFactory;
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
    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        $stockStatus = $this->retailer
            ->client()
            ->checkAvailability($this);

        // Then fresh the current stock record
        $this->update([
            'in_stock' => $stockStatus->available,
            'price' => $stockStatus->price
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
