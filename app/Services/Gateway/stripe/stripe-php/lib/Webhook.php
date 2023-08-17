<?php

namespace StripeJS;

abstract class Webhook
{
    const DEFAULT_TOLERANCE = 300;

    /**
     * Returns an Event instance using the provided JSON payload. Throws a
     * \UnexpectedValueException if the payload is not valid JSON, and a
     * \StripeJS\SignatureVerificationException if the signature verification
     * fails for any reason.
     *
     * @param string $payload the payload sent by StripeJS.
     * @param string $sigHeader the contents of the signature header sent by
     *  StripeJS.
     * @param string $secret secret used to generate the signature.
     * @param int $tolerance maximum difference allowed between the header's
     *  timestamp and the current time
     * @return \StripeJS\Event the Event instance
     * @throws \UnexpectedValueException if the payload is not valid JSON,
     *  \StripeJS\SignatureVerification if the verification fails.
     */
    public static function constructEvent($payload, $sigHeader, $secret, $tolerance = self::DEFAULT_TOLERANCE)
    {
        $data = json_decode($payload, true);
        $jsonError = json_last_error();
        if ($data === null && $jsonError !== JSON_ERROR_NONE) {
            $msg = "Invalid payload: $payload "
              . "(json_last_error() was $jsonError)";
            throw new \UnexpectedValueException($msg);
        }
        $event = Event::constructFrom($data, null);

        WebhookSignature::verifyHeader($payload, $sigHeader, $secret, $tolerance);

        return $event;
    }
}
