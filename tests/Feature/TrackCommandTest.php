<?php

namespace Tests\Feature;

use Facades\App\Clients\ClientFactory;
use App\Clients\StockCheckResponse;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockCheckResponse($available = true, $price = 5000));

        // When
        // The php artisan track command is triggered, assuming the stock is now available
        $this->artisan('track')
            ->expectsOutput(('Product Stock Tracking command run successfully!'));

        // Then
        // The stock details for the product should be refreshed
        $this->assertTrue(Product::first()->inStock());
    }
}
