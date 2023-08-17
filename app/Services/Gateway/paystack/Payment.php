<?php

namespace App\Services\Gateway\paystack;

use App\Models\Fund;
use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $send['key'] = $gateway->parameters->public_key ?? '';
        $send['email'] = optional($order->user)->email;
        $send['amount'] = $order->final_amount * 100;
        $send['currency'] = $order->gateway_currency;
        $send['ref'] = $order->transaction;
        $send['view'] = 'user.payment.paystack';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $secret_key = $gateway->parameters->secret_key ?? '';
        $url = 'https://api.paystack.co/transaction/verify/' . $trx;
        $headers = [
            "Authorization: Bearer {$secret_key}"
        ];
        $response = BasicCurl::curlGetRequestWithHeaders($url, $headers);
        $response = json_decode($response, true);
        if ($response) {
            if ($response['data']) {
                if ($response['data']['status'] == 'success') {
                    $order = Fund::where('transaction', $trx)->latest()->first();
                    $depositAmount = round(($order->final_amount * 100), 2);

                    if (round($response['data']['amount'], 2) == $depositAmount && $response['data']['currency'] == $order->gateway_currency) {
                        BasicService::preparePaymentUpgradation($order);
                        $data['status'] = 'success';
                        $data['msg'] = 'Transaction was successful.';
                        $data['redirect'] = route('success');
                    } else {
                        $data['status'] = 'error';
                        $data['msg'] = 'invalid amount.';
                        $data['redirect'] = route('failed');
                    }
                } else {
                    $data['status'] = 'error';
                    $data['msg'] = $response['data']['gateway_response'];
                    $data['redirect'] = route('failed');
                }
            } else {
                $data['status'] = 'error';
                $data['msg'] = $response['message'];
                $data['redirect'] = route('failed');
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'unexpected error!';
            $data['redirect'] = route('failed');
        }

        return $data;
    }
}
