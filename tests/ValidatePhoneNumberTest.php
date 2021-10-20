<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Tests;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\Numverify\PhoneNumber\ValidPhoneNumber;
use BrokeYourBike\Numverify\PhoneNumber\InvalidPhoneNumber;
use BrokeYourBike\Numverify\Exceptions\ApiResponseException;
use BrokeYourBike\Numverify\Exceptions\ApiFailureException;
use BrokeYourBike\Numverify\ConfigInterface;
use BrokeYourBike\Numverify\Client;

class ValidatePhoneNumberTest extends TestCase
{
    /** @test */
    public function it_can_return_valid_phone_number(): void
    {
        $token = 'some-secure-password';

        $mockedConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();
        $mockedConfig->method('getUrl')->willReturn('https://example.com/');
        $mockedConfig->method('getToken')->willReturn($token);

        $mockedResponse = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')
            ->willReturn('{
                "valid": true,
                "number": "123456789",
                "local_format": "23456789",
                "international_format": "+123456789",
                "country_prefix": "+1",
                "country_code": "US",
                "country_name": "United States of America",
                "location": "Novato",
                "carrier": "AT&T Mobility LLC",
                "line_type": "mobile"
            }');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'GET',
            'https://example.com/validate',
            [
                \GuzzleHttp\RequestOptions::HTTP_ERRORS => false,
                \GuzzleHttp\RequestOptions::QUERY => [
                    'access_key' => $token,
                    'number' => '123456789',
                ],
            ],
        ])->once()->andReturn($mockedResponse);

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);
        $phoneNumber = $api->validatePhoneNumber('123456789');

        $this->assertInstanceOf(ValidPhoneNumber::class, $phoneNumber);
    }

    /** @test */
    public function it_can_return_invalid_phone_number(): void
    {
        $mockedConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();

        $mockedResponse = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')
            ->willReturn('{
                "valid":false,
                "number":"123456789"
            }');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->once()->andReturn($mockedResponse);

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);
        $phoneNumber = $api->validatePhoneNumber('123456789');

        $this->assertInstanceOf(InvalidPhoneNumber::class, $phoneNumber);
    }

    /** @test */
    public function it_will_throw_if_response_missing_required_data(): void
    {
        $mockedConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();

        $mockedResponse = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')
            ->willReturn('{
                "valid": true,
                "number": "123456789",
                "local_format": "23456789",
                "international_format": "+123456789",
                "country_prefix": "+1",
                "country_code": "US",
                "country_name": "United States of America",
                "location": "Novato",
                "line_type": "mobile"
            }');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->once()->andReturn($mockedResponse);

        $this->expectException(ApiResponseException::class);
        $this->expectExceptionMessage('API response does not contain the expected field: carrier');

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);
        $api->validatePhoneNumber('123456789');
    }

    /** @test */
    public function it_will_throw_if_access_code_invalid(): void
    {
        $mockedConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();

        $mockedResponse = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')
            ->willReturn('{
                "success":false,
                "error":{
                    "code":101,
                    "type":"invalid_access_key",
                    "info":"You have not supplied a valid API Access Key. [Technical Support: support@apilayer.com]"
                }
            }');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->once()->andReturn($mockedResponse);

        $this->expectException(ApiFailureException::class);
        $this->expectExceptionMessage('Type:invalid_access_key Code:101 Info:You have not supplied a valid API Access Key. [Technical Support: support@apilayer.com]');

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);
        $api->validatePhoneNumber('123456789');
    }

    /** @test */
    public function it_will_throw_if_bad_response(): void
    {
        $mockedConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();

        $mockedResponse = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(500);
        $mockedResponse->method('getReasonPhrase')->willReturn('Internal Server Error');
        $mockedResponse->method('getBody')->willReturn('server error');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->once()->andReturn($mockedResponse);

        $this->expectException(ApiFailureException::class);
        $this->expectExceptionMessage('Unknown error - 500 Internal Server Error');

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);
        $api->validatePhoneNumber('123456789');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}
