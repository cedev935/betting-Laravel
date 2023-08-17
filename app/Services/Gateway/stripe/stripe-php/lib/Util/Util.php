<?php

namespace StripeJS\Util;

use StripeJS\StripeJSObject;

abstract class Util
{
    private static $isMbstringAvailable = null;
    private static $isHashEqualsAvailable = null;

    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     *
     * @param array|mixed $array
     * @return boolean True if the given object is a list.
     */
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }

      // TODO: generally incorrect, but it's correct given StripeJS's response
        foreach (array_keys($array) as $k) {
            if (!is_numeric($k)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Recursively converts the PHP StripeJS object to an array.
     *
     * @param array $values The PHP StripeJS object to convert.
     * @return array
     */
    public static function convertStripeJSObjectToArray($values)
    {
        $results = array();
        foreach ($values as $k => $v) {
            // FIXME: this is an encapsulation violation
            if ($k[0] == '_') {
                continue;
            }
            if ($v instanceof StripeJSObject) {
                $results[$k] = $v->__toArray(true);
            } elseif (is_array($v)) {
                $results[$k] = self::convertStripeJSObjectToArray($v);
            } else {
                $results[$k] = $v;
            }
        }
        return $results;
    }

    /**
     * Converts a response from the StripeJS API to the corresponding PHP object.
     *
     * @param array $resp The response from the StripeJS API.
     * @param array $opts
     * @return StripeJSObject|array
     */
    public static function convertToStripeJSObject($resp, $opts)
    {
        $types = array(
            'account' => 'StripeJS\\Account',
            'alipay_account' => 'StripeJS\\AlipayAccount',
            'apple_pay_domain' => 'StripeJS\\ApplePayDomain',
            'bank_account' => 'StripeJS\\BankAccount',
            'balance_transaction' => 'StripeJS\\BalanceTransaction',
            'card' => 'StripeJS\\Card',
            'charge' => 'StripeJS\\Charge',
            'country_spec' => 'StripeJS\\CountrySpec',
            'coupon' => 'StripeJS\\Coupon',
            'customer' => 'StripeJS\\Customer',
            'dispute' => 'StripeJS\\Dispute',
            'list' => 'StripeJS\\Collection',
            'login_link' => 'StripeJS\\LoginLink',
            'invoice' => 'StripeJS\\Invoice',
            'invoiceitem' => 'StripeJS\\InvoiceItem',
            'event' => 'StripeJS\\Event',
            'file' => 'StripeJS\\FileUpload',
            'token' => 'StripeJS\\Token',
            'transfer' => 'StripeJS\\Transfer',
            'transfer_reversal' => 'StripeJS\\TransferReversal',
            'order' => 'StripeJS\\Order',
            'order_return' => 'StripeJS\\OrderReturn',
            'payout' => 'StripeJS\\Payout',
            'plan' => 'StripeJS\\Plan',
            'product' => 'StripeJS\\Product',
            'recipient' => 'StripeJS\\Recipient',
            'recipient_transfer' => 'StripeJS\\RecipientTransfer',
            'refund' => 'StripeJS\\Refund',
            'sku' => 'StripeJS\\SKU',
            'source' => 'StripeJS\\Source',
            'subscription' => 'StripeJS\\Subscription',
            'subscription_item' => 'StripeJS\\SubscriptionItem',
            'three_d_secure' => 'StripeJS\\ThreeDSecure',
            'fee_refund' => 'StripeJS\\ApplicationFeeRefund',
            'bitcoin_receiver' => 'StripeJS\\BitcoinReceiver',
            'bitcoin_transaction' => 'StripeJS\\BitcoinTransaction',
        );
        if (self::isList($resp)) {
            $mapped = array();
            foreach ($resp as $i) {
                array_push($mapped, self::convertToStripeJSObject($i, $opts));
            }
            return $mapped;
        } elseif (is_array($resp)) {
            if (isset($resp['object']) && is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
            } else {
                $class = 'StripeJS\\StripeJSObject';
            }
            return $class::constructFrom($resp, $opts);
        } else {
            return $resp;
        }
    }

    /**
     * @param string|mixed $value A string to UTF8-encode.
     *
     * @return string|mixed The UTF8-encoded string, or the object passed in if
     *    it wasn't a string.
     */
    public static function utf8($value)
    {
        if (self::$isMbstringAvailable === null) {
            self::$isMbstringAvailable = function_exists('mb_detect_encoding');

            if (!self::$isMbstringAvailable) {
                trigger_error("It looks like the mbstring extension is not enabled. " .
                    "UTF-8 strings will not properly be encoded. Ask your system " .
                    "administrator to enable the mbstring extension, or write to " .
                    "support@stripe.com if you have any questions.", E_USER_WARNING);
            }
        }

        if (is_string($value) && self::$isMbstringAvailable && mb_detect_encoding($value, "UTF-8", true) != "UTF-8") {
            return utf8_encode($value);
        } else {
            return $value;
        }
    }

    /**
     * Compares two strings for equality. The time taken is independent of the
     * number of characters that match.
     *
     * @param string $a one of the strings to compare.
     * @param string $b the other string to compare.
     * @return bool true if the strings are equal, false otherwise.
     */
    public static function secureCompare($a, $b)
    {
        if (self::$isHashEqualsAvailable === null) {
            self::$isHashEqualsAvailable = function_exists('hash_equals');
        }

        if (self::$isHashEqualsAvailable) {
            return hash_equals($a, $b);
        } else {
            if (strlen($a) != strlen($b)) {
                return false;
            }

            $result = 0;
            for ($i = 0; $i < strlen($a); $i++) {
                $result |= ord($a[$i]) ^ ord($b[$i]);
            }
            return ($result == 0);
        }
    }
}
