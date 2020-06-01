<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

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
        if ($this->retailer->name === 'Amazon') {
            // Hit an API endpoint for the associated retailer
            // Fetch the up to date details for the item
            $results = Http::get('https://foo.test')->json();

            // Then fresh the current stock record
            $this->update([
                'in_stock' => $results['available'],
                'price' => $results['price']
            ]);
        }
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
