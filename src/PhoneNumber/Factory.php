<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\PhoneNumber;

use BrokeYourBike\Numverify\PhoneNumber\ValidPhoneNumber;
use BrokeYourBike\Numverify\PhoneNumber\PhoneNumberInterface;
use BrokeYourBike\Numverify\PhoneNumber\InvalidPhoneNumber;

/**
 * PhoneNumber Factory
 * Role: Factory class to create the appropriate PhoneNumber object
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class Factory
{
    /**
     * Factory creation method
     *
     * @param \stdClass $validatedPhoneNumber
     *
     * @return ValidPhoneNumber|InvalidPhoneNumber
     */
    public static function create(\stdClass $validatedPhoneNumber): PhoneNumberInterface
    {
        if (boolval($validatedPhoneNumber->valid) === false) {
            return new InvalidPhoneNumber($validatedPhoneNumber);
        }

        return new ValidPhoneNumber($validatedPhoneNumber);
    }
}
