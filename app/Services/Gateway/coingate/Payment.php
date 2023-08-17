<?php

namespace App\Services\Gateway\coingate;

use CoinGate\CoinGate;
use CoinGate\Merchant\Order;
use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;


require_once('coingate-php/init.php');

class Payment
{
    public static function prepareData($order, $gateway)
    {

        $basic = (object) config('basic');
        CoinGate::config(array(
            'environment' => 'live', // sandbox OR live
            'auth_token' => $gateway->parameters->api_key
        ));
        $postParams = array(
            'order_id' => $order->trx,
            'price_amount' => $order->final_amount,
            'price_currency' => $order->gateway_currency,
            'receive_currency' => $order->gateway_currency,
            'callback_url' => route('ipn', [$gateway->code, $order->trx]),
            'cancel_url' => route('failed'),
            'success_url' => route('success'),
            'title' => "Payment To {$basic->site_title} Account",
            'token' => $order->trx
        );

        $order = Order::create($postParams);
        if ($order) {
            $send['redirect'] = true;
            $send['redirect_url'] = $order->payment_url;
        } else {
            $send['error'] = true;
            $send['message'] = 'Unexpected Error! Please Try Again';
        }
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $ip = $request->ip();
        $url = 'https://api.coingate.com/v2/ips-v4';
        $response = BasicCurl::curlGetRequest($url);
        if (strpos($response, $ip) !== false) {
            if ($request->status == 'paid' && $request->price_amount == $order->final_amount && $order->status == 0) {
                BasicService::prepareOrderUpgradation($order);
            }
        }
    }
}
