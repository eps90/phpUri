# phpUri

Set of classes to parse and validate URI.

## Basic Usage

The easiest way to start is to create a `StringBasedUriFactory` instance
with injected validator and parser implementations and call `createUri` method:
 
```php
<?php
use EPS\PhpUri\Factory\StringBasedUriFactory;
use EPS\PhpUri\Parser\PhpBuiltInParser;
use EPS\PhpUri\Validator\Rfc3986Validator;

$uriFactory = new StringBasedUriFactory(
    new Rfc3986Validator(),
    new PhpBuiltInParser()
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

Parser implements `Parser` interface and returns an `Uri` object.
Currently there is only one implementation available: `PhpBuiltInParser`
which uses the `parse_url` function to fetch uri parts.

### Formatting

An `UriFormatter` implementing `Formatter` interface will return encoded URI
from URI object. This process is also [RFC 3986 compatible](https://tools.ietf.org/html/rfc3986#section-5.3).

