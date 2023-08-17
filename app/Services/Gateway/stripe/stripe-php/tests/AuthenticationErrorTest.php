<?php

namespace StripeJS;

class AuthenticationErrorTest extends TestCase
{
    public function testInvalidCredentials()
    {
        StripeJS::setApiKey('invalid');
        try {
            Customer::create();
        } catch (Error\Authentication $e) {
            $this->assertSame(401, $e->getHttpStatus());
        }
    }
}
