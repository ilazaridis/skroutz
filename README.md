# Skroutz
[![Travis](https://img.shields.io/travis/ilazaridis/skroutz.svg?style=flat-square)](https://travis-ci.org/ilazaridis/skroutz)
[![Latest Stable Version](https://img.shields.io/packagist/v/ilazaridis/skroutz.svg?style=flat-square)](https://packagist.org/packages/ilazaridis/skroutz)
[![Minimum PHP Version](https://img.shields.io/badge/php-%E2%89%A5%207.0-8892BF.svg?style=flat-square)](https://php.net/)

PHP7 Client for [skroutz](https://skroutz.gr) API
## Installation
```bash
composer require ilazaridis/skroutz
```
## Usage Examples
Once you have an ```Identifier``` and a ```Secret``` you are ready to generate an access token:
```php
<?php

require_once 'vendor/autoload.php';
use ilazaridis\skroutz\Client as Client;

$client = new Client('identifier', 'secret');
```
and consume it:
```php
print_r($client->category('40')->fetch());  // get category with id=40
```
```fetch(bool $decode = true, string $apiVersion = '3.1')``` will return an associative array using latest version of api by default. You can pass a boolean and a string if you want to change these values.
- List the children categories of a category
```php
$client->category('40')->children()->fetch()
```
- Retrieve a single shop location
```php
$client->shop('452')->location('2500')->fetch()
```
- Retrieve manufacturer's categories order by name
```php
$client->category('25')->manufacturers()->params(['order_by' => 'name', 'order_dir' => 'asc'])->fetch()
```
The query string is passd as associative array using the params() method.
In case we have multiple values of the same parameter (i.e. ```filter_ids[]```), we are passing them as comma seperated values:
- Filter SKUs of specific category using multiple filter ids
```php
$client->category('40')->skus()->params(['filter_ids[]' => '355559,6282'])->fetch()
```
## Note
Some of the API methods have not been implemented due to access restriction. Currently,
the acquired permission level is ```public``` and everything on that level was implemented.
