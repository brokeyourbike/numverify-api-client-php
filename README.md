# numverify-api-client-php

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/numverify-api-client-php)](https://github.com/brokeyourbike/numverify-api-client-php/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/numverify-api-client-php/downloads)](https://packagist.org/packages/brokeyourbike/numverify-api-client-php)
[![Maintainability](https://api.codeclimate.com/v1/badges/825df87d0829a388978f/maintainability)](https://codeclimate.com/github/brokeyourbike/numverify-api-client-php/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/825df87d0829a388978f/test_coverage)](https://codeclimate.com/github/brokeyourbike/numverify-api-client-php/test_coverage)

Numverify API Client for PHP

## Installation

```bash
composer require brokeyourbike/numverify-api-client-php
```

## Usage

```php
use BrokeYourBike\Numverify\Client;

$apiClient = new Client($config, $httpClient);
$result = $apiClient->validatePhoneNumber($phoneNumber, $countryCode);
```

## Acknowledgment
Inspired by [markrogoyski/numverify-api-client-php](https://github.com/markrogoyski/numverify-api-client-php)

## Authors
- [Ivan Stasiuk](https://github.com/brokeyourbike) | [Twitter](https://twitter.com/brokeyourbike) | [LinkedIn](https://www.linkedin.com/in/brokeyourbike) | [stasi.uk](https://stasi.uk)

## License
[Mozilla Public License v2.0](https://github.com/brokeyourbike/numverify-api-client-php/blob/main/LICENSE)
