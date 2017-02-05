<?php
namespace ilazaridis\skroutz\tests;

use ilazaridis\skroutz\Client;
use PHPUnit\Framework\TestCase;
class SkuTest extends TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client('test', 'test');
    }

    public function testSingleSku()
    {
        $request = $this->client->sku('3690169');
        $this->assertEquals('/skus/3690169', $request->url);
    }

    public function testSimilarSku()
    {
        $request = $this->client->sku('3690169')->similar();
        $this->assertEquals('/skus/3690169/similar', $request->url);
    }

    public function testSkuProducts()
    {
        $request = $this->client->sku('3690169')->products();
        $this->assertEquals('/skus/3690169/products', $request->url);
    }

    public function testSkuReviews()
    {
        $request = $this->client->sku('3690169')->reviews()->params(['include_meta' => 'sku_rating_breakdown']);
        $this->assertEquals('/skus/3690169/reviews?include_meta=sku_rating_breakdown', $request->url);
    }
}