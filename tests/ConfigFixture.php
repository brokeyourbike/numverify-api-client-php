<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Tests;

use BrokeYourBike\Numverify\ConfigInterface;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class ConfigFixture implements ConfigInterface
{
    public function getUrl(): string
    {
        return 'https://example.com';
    }

    public function getToken(): string
    {
        return 'super-secure-token';
    }

    public function getDataLifetimeSeconds(): int
    {
        return 1;
    }
}
