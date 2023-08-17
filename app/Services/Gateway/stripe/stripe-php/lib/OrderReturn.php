<?php

namespace StripeJS;

/**
 * Class OrderReturn
 *
 * @package StripeJS
 */
class OrderReturn extends ApiResource
{
    /**
     * @param array|string $id The ID of the order return to retrieve, or an
     *     options array containing an `id` field.
     * @param array|string|null $opts
     *
     * @return Order
     */
    public static function retrieve($id, $opts = null)
    {
        return self::_retrieve($id, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection of OrderReturns
     */
    public static function all($params = null, $opts = null)
    {
        return self::_all($params, $opts);
    }
}
