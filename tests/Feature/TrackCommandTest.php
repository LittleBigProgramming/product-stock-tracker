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
        $this->seed(\RetailerWithProductSeeder::class);
        $this->assertFalse(Product::first()->inStock());
        // When
        // The php artisan track command is triggered, assuming the stock is now available
        Http::fake(fn() => [
                'available' => 'true',
                'price' => 25000
        ]);

        $this->artisan('track')
            ->expectsOutput(('Product Stock Tracking command run successfully!'));

        // Then
        // The stock details for the product should be refreshed
        $this->assertFalse(Product::first()->inStock());
    }
}
