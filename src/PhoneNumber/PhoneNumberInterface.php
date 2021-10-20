<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\PhoneNumber;

/**
 * Interface for all phone numbers returned from the Numverify validate API
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
interface PhoneNumberInterface
{
    public function isValid(): bool;

    public function getNumber(): string;
}
