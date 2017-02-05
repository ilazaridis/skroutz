<?php namespace ilazaridis\skroutz\tests;

use ilazaridis\skroutz\Client;
use PHPUnit\Framework\TestCase;

class ManufacturerTest extends TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client('test', 'test');
    }

    public function testAllManufacturers()
    {
        $request = $this->client->manufacturer();
        $this->assertEquals('/manufacturers', $request->url);
    }

    public function testSingleManufacturer()
    {
        $request = $this->client->manufacturer('12907');
        $this->assertEquals('/manufacturers/12907', $request->url);
    }

    public function testManufacturerCategories()
    {
        $request = $this->client->manufacturer('12907')->categories()->params(['order_by' => 'name', 'order_dir' => 'asc']);
        $this->assertEquals('/manufacturers/12907/categories?order_by=name&order_dir=asc', $request->url);
    }

    public function testManufacturerSkus()
    {
        $request = $this->client->manufacturer('356')->skus()->params(['order_by' => 'price']);
        $this->assertEquals('/manufacturers/356/skus?order_by=price', $request->url);
    }
}