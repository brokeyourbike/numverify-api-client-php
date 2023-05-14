<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Numverify\Exceptions;

/**
 * Thrown when the Numverify API returns a failure response
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
final class ApiFailureException extends \RuntimeException
{
    /** @var int */
    private $statusCode;

    /** @var string */
    private $reasonPhrase;

    /** @var \Psr\Http\Message\StreamInterface */
    private $body;

    /**
     * NumverifyApiFailureException constructor
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(\Psr\Http\Message\ResponseInterface $response)
    {
        $this->statusCode   = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        $this->body         = $response->getBody();

        $message = $this->parseMessageFromBody((string) $this->body);

        parent::__construct($message);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return (string) $this->body;
    }

    /**
     * Parse JSON body error message
     *
     * Expecting a JSON body like:
     * {
     *     "success":false,
     *     "error":{
     *         "code":101,
     *         "type":"invalid_access_key",
     *         "info":"You have not supplied a valid API Access Key. [Technical Support: support@apilayer.com]"
     *     }
     * }
     *
     * @param string $jsonBody
     *
     * @return string
     */
    private function parseMessageFromBody(string $jsonBody): string
    {
        $body = json_decode($jsonBody, false);

        if (!is_object($body) || (is_object($body) && !isset($body->error))) {
            return "Unknown error - {$this->statusCode} {$this->getReasonPhrase()}";
        }

        $error = $body->error;
        return sprintf('Type:%s Code:%d Info:%s', $error->type, $error->code, $error->info);
    }
}
