<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Tests\PhoneNumber;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\Numverify\PhoneNumber\ValidPhoneNumber;
use BrokeYourBike\Numverify\Exceptions\ApiResponseException;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class ValidPhoneNumberTest extends TestCase
{
    private const VALID                = true;
    private const NUMBER               = '123456789';
    private const LOCAL_FORMAT         = '23456789';
    private const INTERNATIONAL_FORMAT = '+123456789';
    private const COUNTRY_PREFIX       = '+1';
    private const COUNTRY_CODE         = 'US';
    private const COUNTRY_NAME         = 'United States of America';
    private const LOCATION             = 'Novato';
    private const CARRIER              = 'AT&T Mobility LLC';
    private const LINE_TYPE            = 'mobile';

    /** @var object */
    private $phoneNumberData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->phoneNumberData = (object) [
            'valid'                => self::VALID,
            'number'               => self::NUMBER,
            'local_format'         => self::LOCAL_FORMAT,
            'international_format' => self::INTERNATIONAL_FORMAT,
            'country_prefix'       => self::COUNTRY_PREFIX,
            'country_code'         => self::COUNTRY_CODE,
            'country_name'         => self::COUNTRY_NAME,
            'location'             => self::LOCATION,
            'carrier'              => self::CARRIER,
            'line_type'            => self::LINE_TYPE,
        ];
    }

    /** @test */
    public function it_will_return_values_from_getters(): void
    {
        $phoneNumber = new ValidPhoneNumber($this->phoneNumberData);

        $this->assertTrue($phoneNumber->isValid());
        $this->assertSame(self::NUMBER, $phoneNumber->getNumber());
        $this->assertSame(self::LOCAL_FORMAT, $phoneNumber->getLocalFormat());
        $this->assertSame(self::INTERNATIONAL_FORMAT, $phoneNumber->getInternationalFormat());
        $this->assertSame(self::COUNTRY_PREFIX, $phoneNumber->getCountryPrefix());
        $this->assertSame(self::COUNTRY_CODE, $phoneNumber->getCountryCode());
        $this->assertSame(self::COUNTRY_NAME, $phoneNumber->getCountryName());
        $this->assertSame(self::LOCATION, $phoneNumber->getLocation());
        $this->assertSame(self::CARRIER, $phoneNumber->getCarrier());
        $this->assertSame(self::LINE_TYPE, $phoneNumber->getLineType());
    }

    /**
     * @test
     *
     * @dataProvider fieldsProvider
     *
     * @param string $fieldName
     *
     * @return void
     */
    public function it_will_throw_if_field_missing(string $fieldName): void
    {
        unset($this->phoneNumberData->$fieldName);

        $this->expectException(ApiResponseException::class);

        new ValidPhoneNumber($this->phoneNumberData);
    }

    /**
     * @return array
     */
    public function fieldsProvider(): array
    {
        return [
            ['valid'],
            ['number'],
            ['local_format'],
            ['international_format'],
            ['country_prefix'],
            ['country_code'],
            ['country_name'],
            ['location'],
            ['carrier'],
            ['line_type'],
        ];
    }
}
