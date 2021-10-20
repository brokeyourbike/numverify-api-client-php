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
 * ValidPhoneNumber
 * Role: Value object to represent a phone number that the Numverify returned as valid
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class ValidPhoneNumber implements PhoneNumberInterface
{
    /** @var bool */
    private $valid;

    /** @var string */
    private $number;

    /** @var string */
    private $localFormat;

    /** @var string */
    private $internationalFormat;

    /** @var string */
    private $countryPrefix;

    /** @var string */
    private $countryCode;

    /** @var string */
    private $countryName;

    /** @var string */
    private $location;

    /** @var string */
    private $carrier;

    /** @var string */
    private $lineType;

    private const FIELDS = [
        'valid',
        'number',
        'local_format',
        'international_format',
        'country_prefix',
        'country_code',
        'country_name',
        'location',
        'carrier',
        'line_type',
    ];

    /**
     * ValidPhoneNumber constructor
     *
     * @param \stdClass $validatedPhoneNumberData
     */
    public function __construct(\stdClass $validatedPhoneNumberData)
    {
        $this->verifyPhoneNumberData($validatedPhoneNumberData);

        $this->valid               = boolval($validatedPhoneNumberData->valid);
        $this->number              = (string) $validatedPhoneNumberData->number;
        $this->localFormat         = (string) $validatedPhoneNumberData->local_format;
        $this->internationalFormat = (string) $validatedPhoneNumberData->international_format;
        $this->countryPrefix       = (string) $validatedPhoneNumberData->country_prefix;
        $this->countryCode         = (string) $validatedPhoneNumberData->country_code;
        $this->countryName         = (string) $validatedPhoneNumberData->country_name;
        $this->location            = (string) $validatedPhoneNumberData->location;
        $this->carrier             = (string) $validatedPhoneNumberData->carrier;
        $this->lineType            = (string) $validatedPhoneNumberData->line_type;
    }

    /**
     * Is the phone number valid?
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * Get phone number
     *
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Get local format
     *
     * @return string
     */
    public function getLocalFormat(): string
    {
        return $this->localFormat;
    }

    /**
     * Get international format
     *
     * @return string
     */
    public function getInternationalFormat(): string
    {
        return $this->internationalFormat;
    }

    /**
     * Get country prefix
     *
     * @return string
     */
    public function getCountryPrefix(): string
    {
        return $this->countryPrefix;
    }

    /**
     * Get country code
     *
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * Get country name
     *
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Get carrier
     *
     * @return string
     */
    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /**
     * Get line type
     *
     * @return string
     */
    public function getLineType(): string
    {
        return $this->lineType;
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
