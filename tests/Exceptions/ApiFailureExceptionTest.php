<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\Numverify\Exceptions\ApiFailureException;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class ApiFailureExceptionTest extends TestCase
{
    private const STATUS_CODE   = 500;
    private const REASON_PHRASE = 'Internal Server Error';
    private const BODY          = 'server error';

    /** @var \Psr\Http\Message\ResponseInterface|MockObject */
    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)->getMock();
        $this->response->method('getStatusCode')->willReturn(self::STATUS_CODE);
        $this->response->method('getReasonPhrase')->willReturn(self::REASON_PHRASE);
        $this->response->method('getBody')->willReturn(self::BODY);
    }

    /** @test */
    public function it_will_return_values_from_getters(): void
    {
        $exception = new ApiFailureException($this->response);

        $this->assertSame(self::STATUS_CODE, $exception->getStatusCode());
        $this->assertSame(self::REASON_PHRASE, $exception->getReasonPhrase());
        $this->assertSame(self::BODY, $exception->getBody());
    }
}
