<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Tests;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\Numverify\ConfigInterface;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class ConfigTest extends TestCase
{
    /** @test */
    public function it_implemets_config_interface(): void
    {
        $this->assertInstanceOf(ConfigInterface::class, new ConfigFixture());
    }
}
