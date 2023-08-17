<?php

namespace StripeJS\Error;

class InvalidRequest extends Base
{
    public function __construct(
        $message,
        $StripeJSParam,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {
        parent::__construct($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders);
        $this->StripeJSParam = $StripeJSParam;
    }

    public function getStripeJSParam()
    {
        return $this->StripeJSParam;
    }
}
