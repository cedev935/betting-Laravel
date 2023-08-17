<?php

namespace StripeJS;

class RateLimitErrorTest extends TestCase
{
    private function rateLimitErrorResponse()
    {
        return array(
            'error' => array(),
        );
    }

    /**
     * @expectedException StripeJS\Error\RateLimit
     */
    public function testRateLimit()
    {
        $this->mockRequest('GET', '/v1/accounts/acct_DEF', array(), $this->rateLimitErrorResponse(), 429);
        Account::retrieve('acct_DEF');
    }
}
