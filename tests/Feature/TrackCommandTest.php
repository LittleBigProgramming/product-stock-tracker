<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     *
     * @test
     */
    public function it_tracks_product_stock()
    {
        // Given
        // A product with a stock
        $switch = Product::create(['name' => 'Nintendo Switch']);
        $amazon = Retailer::create(['name' => 'Amazon']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price' => 10000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => false
        ]);

        $amazon->addStock($switch, $stock);
        $this->assertFalse($stock->fresh()->in_stock);


        // When
        // The php artisan track command is triggered, assuming the stock is now available
        Http::fake(function () {
            return [
                'available' => 'true',
                'price' => 25000
            ];
        });

        $this->artisan('track');

        // Then
        // The stock details for the product should be refreshed
        $this->assertTrue($stock->fresh()->in_stock);
    }
}
