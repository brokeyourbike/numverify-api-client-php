<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\Numverify\Exceptions\ApiResponseException;

class ApiResponseExceptionTest extends TestCase
{
    /** @test */
    public function it_will_return_message(): void
    {
        $exception = new ApiResponseException('Test message', new \stdClass());

        $this->assertSame('Test message', $exception->getMessage());
    }
}
