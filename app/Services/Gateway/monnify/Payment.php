<?php

namespace App\Services\Gateway\monnify;

use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $send['api_key'] = $gateway->parameters->api_key ?? '';
        $send['contract_code'] = $gateway->parameters->contract_code ?? '';
        $send['amount'] = round($order->final_amount,2);
        $send['currency'] = $order->gateway_currency;
        $send['customer_name'] = optional($order->user)->username ?? '';
        $send['customer_email'] = optional($order->user)->email ?? '';
        $send['customer_phone'] = optional($order->user)->phone ?? '';
        $send['ref'] = $order->transaction;
        $send['description'] = "Pay to {$basic->site_title}";
        $send['view'] = 'user.payment.monnify';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $apiKey = $gateway->parameters->api_key ?? '';
        $secretKey = $gateway->parameters->secret_key ?? '';
        $url = "https://sandbox.monnify.com/api/v1/merchant/transactions/query?paymentReference={$trx}";
        $headers = [
            "Authorization: Basic " . base64_encode($apiKey . ':' . $secretKey)
        ];
        $response = BasicCurl::curlGetRequestWithHeaders($url, $headers);
        $response = json_decode($response);
        if ($response->requestSuccessful && $response->responseMessage == "success") {
            if ($response->responseBody->amount == round($order->final_amount,2) &&  $response->responseBody->currencyCode == $order->gateway_currency && $order->status == 0) {
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
            $data['msg'] = 'unable to Process.';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
