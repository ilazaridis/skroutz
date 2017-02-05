<?php namespace ilazaridis\Tests;

use PHPUnit\Framework\TestCase;
use ilazaridis\skroutz\Client;


class CategoryTest extends TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client('test', 'test');
    }

    public function testListAllCategories()
    {
        $request = $this->client->category();
        $this->assertEquals($request->url, '/categories');
    }

    public function testSingleCategory()
    {
        $request = $this->client->category('1442');
        $this->assertEquals($request->url, '/categories/1442');
    }

    public function testCategoryParent()
    {
        $request = $this->client->category('1442')->parent();
        $this->assertEquals($request->url, '/categories/1442/parent');
    }

    public function testCategoryRoot()
    {
        $request = $this->client->category()->root();
        $this->assertEquals($request->url, '/categories/root');
    }

    public function testCategoryChildren()
    {
        $request = $this->client->category('252')->children();
        $this->assertEquals($request->url, '/categories/252/children');
    }

    public function testCategorySpecs()
    {
        $request = $this->client->category('40')->specifications();
        $this->assertEquals($request->url, '/categories/40/specifications');
    }

    public function testCategorySpecsIncGroup()
    {
        $request = $this->client->category('40')->specifications()->params(['include' => 'group']);
        $this->assertEquals($request->url, '/categories/40/specifications?include=group');
    }

    public function testCategoryManufacturers()
    {
        $request = $this->client->category('25')->manufacturers();
        $this->assertEquals($request->url, '/categories/25/manufacturers');
    }

    public function testCategoryManufacturersOrder()
    {
        $request = $this->client->category('25')->manufacturers()->params(['order_by' => 'name', 'order_dir' => 'asc']);
        $this->assertEquals($request->url, '/categories/25/manufacturers?order_by=name&order_dir=asc');
    }

    public function testCategorySku()
    {
        $request = $this->client->category('40')->skus()->params(['order_by' => 'rating']);
        $this->assertEquals($request->url, '/categories/40/skus?order_by=rating');
    }

    public function testCategorySkuFilterByManufacturer()
    {
        $request = $this->client->category('40')->skus()->params(['manufacturer_ids[]' => '28,2']);
        $this->assertEquals($request->url, '/categories/40/skus?manufacturer_ids[]=28&manufacturer_ids[]=2');
    }

    public function testCategorySkuFilterByFilters()
    {
        $request = $this->client->category('40')->skus()->params(['filter_ids[]' => '355559, 6282']);
        $this->assertEquals('/categories/40/skus?filter_ids[]=355559&filter_ids[]=6282', $request->url);
    }

    public function testCategorySkuFilterManufacturersMeta()
    {
        //http://api.skroutz.gr/categories/40/skus?include_meta=applied_filters&filter_ids[]=6282&manufacturer_ids[]=28
        $request = $this->client->category('40')->skus()->params(['include_meta' => 'applied_filters', 'filter_ids[]' => '355559,6282', 'manufacturer_ids[]' => '26,24']);
        $this->assertEquals('/categories/40/skus?include_meta=applied_filters&filter_ids[]=355559&filter_ids[]=6282&manufacturer_ids[]=26&manufacturer_ids[]=24', $request->url);
    }
}