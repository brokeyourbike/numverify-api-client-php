<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\PhoneNumber;

use BrokeYourBike\Numverify\PhoneNumber\PhoneNumberInterface;
use BrokeYourBike\Numverify\Exceptions\ApiResponseException;

/**
 * InvalidPhoneNumber
 * Role: Value object to represent a phone number that the Numverify returned as invalid
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class InvalidPhoneNumber implements PhoneNumberInterface
{
    /** @var bool */
    private $valid;

    /** @var string */
    private $number;

    private const FIELDS = ['valid', 'number'];

    /**
     * InvalidPhoneNumber constructor
     *
     * @param \stdClass $validatedPhoneNumber
     */
    public function __construct(\stdClass $validatedPhoneNumber)
    {
        $this->verifyPhoneNumberData($validatedPhoneNumber);

        $this->valid  = boolval($validatedPhoneNumber->valid);
        $this->number = (string) $validatedPhoneNumber->number;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Verify the phone number data contains the expected fields
     *
     * @param \stdClass $phoneNumberData
     * @return void
     *
     * @throws ApiResponseException
     */
    private function verifyPhoneNumberData(\stdClass $phoneNumberData)
    {
        foreach (self::FIELDS as $field) {
            if (!isset($phoneNumberData->$field)) {
                throw new ApiResponseException("API response does not contain the expected field: $field", $phoneNumberData);
            }
        }
    }
}
