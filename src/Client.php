<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify;

use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\Numverify\PhoneNumber\ValidPhoneNumber;
use BrokeYourBike\Numverify\PhoneNumber\PhoneNumberInterface;
use BrokeYourBike\Numverify\PhoneNumber\InvalidPhoneNumber;
use BrokeYourBike\Numverify\PhoneNumber\Factory;
use BrokeYourBike\Numverify\Exceptions\ApiFailureException;
use BrokeYourBike\Numverify\ConfigInterface;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class Client implements HttpClientInterface
{
    use HttpClientTrait;
    use ResolveUriTrait;

    private ConfigInterface $config;

    public function __construct(ConfigInterface $config, \GuzzleHttp\ClientInterface $httpClient)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }

    /**
     * Validate a phone number
     *
     * @param string $phoneNumber
     * @param string|null $countryCode
     *
     * @return ValidPhoneNumber|InvalidPhoneNumber
     *
     * @throws \RuntimeException
     */
    public function validatePhoneNumber(string $phoneNumber, ?string $countryCode = null): PhoneNumberInterface
    {
        $query = [
            'access_key' => $this->config->getToken(),
            'number'     => $phoneNumber,
        ];

        if ($countryCode !== null) {
            $query['country_code'] = $countryCode;
        }

        $result = $this->httpClient->request(
            'GET',
            (string) $this->resolveUriFor($this->config->getUrl(), 'validate'),
            [
                \GuzzleHttp\RequestOptions::HTTP_ERRORS => false,
                \GuzzleHttp\RequestOptions::QUERY => $query,
            ]
        );
        $this->validateResponse($result);

        /** @var \stdClass */
        $body = \json_decode((string) $result->getBody());
        return Factory::create($body);
    }

    /**
     * Validate the response
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return void
     *
     * @throws ApiFailureException if the response is non 200 or success field is false
     */
    private function validateResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new ApiFailureException($response);
        }

        /** @var mixed */
        $body = \json_decode((string) $response->getBody());
        if ($body instanceof \stdClass && isset($body->success) && $body->success == false) {
            throw new ApiFailureException($response);
        }
    }
}
