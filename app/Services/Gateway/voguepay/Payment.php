<?php

namespace App\Services\Gateway\voguepay;


use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $send['v_merchant_id'] = $gateway->parameters->merchant_id ?? '';
        $send['notify_url'] = route('ipn', [$gateway->code, $order->transaction]);
        $send['cur'] = $order->gateway_currency;
        $send['merchant_ref'] = $order->transaction;
        $send['memo'] = "Pay to {$basic->site_title}";
        $send['store_id'] = $order->user_id;
        $send['custom'] = $order->transaction;
        $send['Buy'] = round($order->final_amount, 2);
        $send['view'] = 'user.payment.voguepay';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $trx = $request->transaction_id;
        $url = "https://voguepay.com/?v_transaction_id={$type}&type=json";
        $response = BasicCurl::curlGetRequest($url);
        $response = json_decode($response);
        $merchantId = $gateway->parameters->merchant_id ?? '';
        if ($response->status == "Approved" && $response->merchant_id == $merchantId && $response->total == round($order->final_amount, 2) && $response->cur_iso == $order->gateway_currency) {
            BasicService::preparePaymentUpgradation($order);

            $data['status'] = 'success';
            $data['msg'] = 'Transaction was successful.';
            $data['redirect'] = route('success');
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'unexpected error!';
            $data['redirect'] = route('failed');
        }

        return $data;
    }
}
