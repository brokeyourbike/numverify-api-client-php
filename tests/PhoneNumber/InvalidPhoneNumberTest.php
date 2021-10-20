<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Tests\PhoneNumber;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\Numverify\PhoneNumber\InvalidPhoneNumber;
use BrokeYourBike\Numverify\Exceptions\ApiResponseException;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class InvalidPhoneNumberTest extends TestCase
{
    /** @var object */
    private $phoneNumberData;

    private const VALID  = false;
    private const NUMBER = '12345679';

    protected function setUp(): void
    {
        parent::setUp();

        $this->phoneNumberData = (object) [
            'valid'                => self::VALID,
            'number'               => self::NUMBER,
        ];
    }

    /** @test */
    public function it_will_return_values_from_getters(): void
    {
        $phoneNumber = new InvalidPhoneNumber($this->phoneNumberData);

        $this->assertFalse($phoneNumber->isValid());
        $this->assertSame(self::NUMBER, $phoneNumber->getNumber());
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

        new InvalidPhoneNumber($this->phoneNumberData);
    }

    /**
     * @return array
     */
    public function fieldsProvider(): array
    {
        return [
            ['valid'],
            ['number'],
        ];
    }
}
