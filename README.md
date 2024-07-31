# BNB Fixing XML Wrapper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mchervenkov/bnbfixing.svg?style=flat-square)](https://packagist.org/packages/mchervenkov/bnbfixing)
[![Total Downloads](https://img.shields.io/packagist/dt/mchervenkov/bnbfixing.svg?style=flat-square)](https://packagist.org/packages/mchervenkov/bnbfixing)

## Installation

You can install the package via composer:

```bash
composer require mchervenkov/bnbfixing
```

If you plan to use database for storing bnb exchange rates:

```bash
php artisan migrate
```

If you need to export configuration file:

```bash
php artisan vendor:publish --tag=bnbfixing-config
```

If you need to export migrations:

```bash
php artisan vendor:publish --tag=bnbfixing-migrations
```

If you need to export models:

```bash
php artisan vendor:publish --tag=bnbfixing-models
```

If you need to export commands:

```bash
php artisan vendor:publish --tag=bnbfixing-commands
```

## Usage
Methods
```php

// Init BnbFixing Client
$bnbFixing = new BnbFixing();

// Return Bnb exchange rates in xml string format
$bnbFixing->getXmlContent();

// Get Certain exchange rate by code for certain bulgarian lev amount
// This will return how much Euro are 100 bulgarian lev
$bnbFixing->geExchangeBGNRateAmount('EUR', 100);

// Get Bulgarian Lev Rate for certain exchange rate and amount
// This will return how much bulgarian lev are 100 Euro
$bnbFixing->getReverseExchangeBGNRateAmount('EUR', 100);

// Get Amount between two exchange rates depends on BNB Fixings
// This will return how much euro are 100 american dollars
$bnbFixing->getExchangeRate('USD', 'EUR', 100);
```

Commands

```bash
#get exchange rates and insert them into database
php artisan bnb-fixing:sync-bnbfixing
```

Models
```php
BnbFixing
```

## Examples

Get xml content
```php
$bnbFixing = new BnbFixing();
$xmlContent = $bnbFixing->getXmlContent();
dd($xmlContent);
```

Certain Exchange rate from bulgarian lev amount (100 Bulgarian lev to American dollars)
```php
$bnbFixing = new BnbFixing();
$usd = $bnbFixing->getExchangeRateAmount('USD', 100);
dd($usd);
```

Certain Exchange rate to bulgarian lev (100 American Dollars to Lev)
```php
$bnbFixing = new BnbFixing();
$lev = $bnbFixing->getReverseExchangeRateAmount('USD', 100);
dd($lev)
```

### Testing
Before running tests config xml_url in phpunit.xml file
```bash
<php>
   <env name="BNB_XML_URL" value="https://www.bnb.bg/Statistics/StExternalSector/StExchangeRates/StERForeignCurrencies/?download=xml"/>
</php>
```
```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mario.chervenkov@gmail.com instead of using the issue tracker.

## Credits

-   [Mario Chervenkov](https://github.com/mariochervenkov)
-   [silabg.com](https://www.silabg.com/) :heart:
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

