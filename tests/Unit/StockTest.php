<?php

namespace Tests\Unit;


use App\Clients\Client;
use App\Clients\ClientException;
use Facades\App\Clients\ClientFactory;
use App\Clients\StockCheckResponse;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_throws_an_exception_if_a_client_is_not_found_when_tracking()
    {
        $this->seed(\RetailerWithProductSeeder::class);
        Retailer::first()->update(['name' => 'Foo Retailer']);

        $this->expectException(ClientException::class);

        Stock::first()->track();
    }

    /** @test **/
    function it_updates_local_stock_status_after_being_tracked()
    {
        $this->seed(\RetailerWithProductSeeder::class);
        // Uses client factory to determine the appropriate client
        // And runs checkAvailablity
        ClientFactory::shouldReceive('make')->andReturn(new FakeClient);



        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(5000, $stock->price);
    }
}

class FakeClient implements Client
{
    public function checkAvailability(Stock $stock): StockCheckResponse
    {
        return new StockCheckResponse($available = true, $price = 5000);
    }
}
