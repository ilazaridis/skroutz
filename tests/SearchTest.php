<?php namespace ilazaridis\skroutz\tests;

use ilazaridis\skroutz\Client;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client('test', 'test');
    }

    public function testSearch()
    {
        $request = $this->client->search()->params(['q' => 'samsung s7 edge duos']);
        $this->assertEquals('/search?q=samsung+s7+edge+duos', $request->url);
    }

    public function testAutocomplete()
    {
        $request = $this->client->autocomplete()->params(['q' => 'iph']);
        $this->assertEquals('/autocomplete?q=iph', $request->url);
    }
}