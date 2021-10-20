<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Exceptions;

/**
 * Thrown when the Numverify API returns an API response that is unexpected
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
final class ApiResponseException extends \RuntimeException
{
    /** @var \stdClass */
    private $phoneNumberData;

    /**
     * NumverifyApiResponseException constructor
     *
     * @param string    $message
     * @param \stdClass $phoneNumberData
     */
    public function __construct(string $message, \stdClass $phoneNumberData)
    {
        $this->phoneNumberData = $phoneNumberData;

        parent::__construct($message);
    }
}
