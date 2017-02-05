<?php namespace ilazaridis\skroutz\tests;

use ilazaridis\skroutz\Client;
use PHPUnit\Framework\TestCase;

class ShopTest extends TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client('test', 'test');
    }

    public function testSingleShop()
    {
        $request = $this->client->shop('452');
        $this->assertEquals('/shops/452', $request->url);
    }

    public function testShopReview()
    {
        $request = $this->client->shop('452')->reviews()->params(['include_meta' =>'shop_rating_breakdown']);
        $this->assertEquals('/shops/452/reviews?include_meta=shop_rating_breakdown', $request->url);
    }

    public function testShopLocations()
    {
        $request = $this->client->shop('452')->locations()->params(['embed' => 'address']);
        $this->assertEquals('/shops/452/locations?embed=address', $request->url);
    }

    public function testSingleShopLocation()
    {
        $request = $this->client->shop('452')->locations('2500');
        $this->assertEquals('/shops/452/locations/2500', $request->url);
    }

    public function testShopSearch()
    {
        $request = $this->client->shop()->params(['q' => 'spartoo']);
        $this->assertEquals('/shops?q=spartoo', $request->url);
    }
}