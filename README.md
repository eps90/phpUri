# phpUri

Set of classes to parse and validate URI.

## Basic Usage

The easiest way to start is to create a `StringBasedUriFactory` instance
with injected validator and parser implementations and call `createUri` method:
 
```php
<?php
use EPS\PhpUri\Factory\StringBasedUriFactory;
use EPS\PhpUri\Parser\Rfc3986Parser;
use EPS\PhpUri\Validator\Rfc3986Validator;

$uriFactory = new StringBasedUriFactory(
    new Rfc3986Validator(),
    new Rfc3986Parser()
);
$uri = $uriFactory->createUri('http://user:pass@example.com/path');
```

The result of `createUri` method is an `Uri` instance with URI parts:
 
* Scheme
* Authority
    * User
    * Password
    * Host
    * Port
* Path
* Query
* Fragment


### Validation

Input URI string can be validate by one of validators implementing `Validator`
interface. The `Validator::validate($uri)` method can return true or throw an 
`ValidatorException` if validation fails. Currently following validators are available:

#### RFC Validators

* `Rfc2396Validator` - based on RFC 2396 specs. Internally uses `filter_var` function 
with `FILTER_VALIDATE_URL` filter which is 
[compatible with this spec](http://nl1.php.net/manual/en/filter.filters.validate.php).
* `Rfc3986Validator` - based on RFC 3986 specs. Uses set of regular expressions to strictly match
specs conditions.

#### Parts validators

You can validate only part of an URI with one (or more) validators available.
Each URI part has own validator which can be used explicitly:

* `SchemeValidator`
* `AuthorityValidator`
* `PathValidator`
* `QueryValidator`
* `FragmentValidator`

Each of these validators follow RFC 3986 specs. 

#### Aggregated validators

Very probably that you may want to use many validators in validation process. 
The `AggregatedValidator` class can run validation one-by-one by calling `validate`
method (from `Validator` interface):

```php
<?php

$aggregated = new \EPS\PhpUri\Validator\AggregatedValidator([
    new \EPS\PhpUri\Validator\SchemeValidator(),
    new \EPS\PhpUri\Validator\QueryValidator()
]);
$result = $aggregated->validate('http://example.com?query=123');
```
> **Note:** Actually, the `Rfc3986Validator` encapsulates an `AggregatedVaidator` 
> with `SchemeValidator`, `AuthorityValidator`, `PathValidator`, `QueryValidator`
> and `FragmentValidator`

### Parsing

Parsers implement `Parser` interface and returns an `Uri` object.
Currently there are two implementations available:

* `PhpBuiltInParser` uses the `parse_url` function to fetch uri parts
* `Rfc3986Parser` - uses a [slightly modified unpack regex](https://tools.ietf.org/html/rfc3986#appendix-B) 
to fetch URI parts

### Formatting

An `UriFormatter` implementing `Formatter` interface will return encoded URI
from URI object. This process is also [RFC 3986 compatible](https://tools.ietf.org/html/rfc3986#section-5.3).

## REST API

This project contains very simple REST API built on [Silex](http://silex.sensiolabs.org/).
You can validate and parse your URI via HTTP by sending a json with URI **OR**
send uri parts to create URI.

Routes implemented so far:

* `GET /uri` - send an URI in json to retrieve URI parts. Response codes:
  * **200** - successful validation and parsing
  * **400** - improperly formatted request
  * **422** - validation failed
  * **500** - generic error
* `POST /uri` - send URI parts to retrieve json with formatted URI
  * **201** - URI created
  * **400** - improperly formatted request
  * **500** - generic error
  
The response of `GET /uri` and request payload of `POST /uri` is the same - it's serialized URI object.
  
### Running on PHP server

You can use PHP built-in HTTP server to run this REST API. Simply run:

```bash
php -S localhost:8081 -t web/
```

### Examples

```bash
# Parse URI
curl http://localhost:8018/uri -XGET -d '{"uri":"http:\/\/example.com\/some\/path"}' -H 'Content-Type: application/json'

# Create URI
curl http://localhost:8081/uri -XPOST -d '{"scheme":"http","authority":{"host":"example.com"}}' -H 'Content-Type: application/json' 
```

## Development and testing

To install project, first you need to download of dependencies using Composer:

```bash
composer install
```

To run unit test with PHPUnit, use following command:

```bash
bin/phpunit 
```
