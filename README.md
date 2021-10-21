# numverify-api-client-php

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/numverify-api-client-php)](https://github.com/brokeyourbike/numverify-api-client-php/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/numverify-api-client-php/downloads)](https://packagist.org/packages/brokeyourbike/numverify-api-client-php)
[![License: MPL-2.0](https://img.shields.io/badge/license-MPL--2.0-purple.svg)](https://github.com/brokeyourbike/numverify-api-client-php/blob/main/LICENSE)

[![ci](https://github.com/brokeyourbike/numverify-api-client-php/actions/workflows/ci.yml/badge.svg)](https://github.com/brokeyourbike/numverify-api-client-php/actions/workflows/ci.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/825df87d0829a388978f/maintainability)](https://codeclimate.com/github/brokeyourbike/numverify-api-client-php/maintainability)
[![codecov](https://codecov.io/gh/brokeyourbike/numverify-api-client-php/branch/main/graph/badge.svg?token=ImcgnxzGfc)](https://codecov.io/gh/brokeyourbike/numverify-api-client-php)

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

## License
[Mozilla Public License v2.0](https://github.com/brokeyourbike/numverify-api-client-php/blob/main/LICENSE)
