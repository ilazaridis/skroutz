<?php namespace ilazaridis\skroutz\tests;

use ilazaridis\skroutz\Client;
use PHPUnit\Framework\TestCase;

class FlagsTest extends TestCase
{

    protected $client;

    public function setUp()
    {
        $this->client = new Client('test', 'test');
    }

    public function testFlags()
    {
        $request = $this->client->flag();
        $this->assertEquals('/flags', $request->url);
    }
}