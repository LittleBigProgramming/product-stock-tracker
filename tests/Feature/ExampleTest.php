<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_checks_stock_for_products_retailers()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);
        $amazon = Retailer::create(['name' => 'Amazon']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price' => 10000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => true
        ]);

        $amazon->addStock($switch, $stock);

        $this->assertTrue($switch->inStock());
    }
}
