<?php namespace ilazaridis\skroutz\tests;

use PHPUnit\Framework\TestCase;
use ilazaridis\skroutz\Client;

class ProductTest extends TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client('test', 'test');
    }

    public function testSingleProduct()
    {
        $request = $this->client->product('12176638');
        $this->assertEquals($request->url, '/products/12176638');
    }

    public function testProductSearch()
    {
        $request = $this->client->shop('452')->products()->search()->params(['shop_uid' => '95F']);
        $this->assertEquals($request->url, '/shops/452/products/search?shop_uid=95F');
    }
}