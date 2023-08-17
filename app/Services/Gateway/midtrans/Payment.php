<?php

namespace App\Services\Gateway\midtrans;

use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;


class Payment
{
    public static function prepareData($order, $gateway)
    {
        \Midtrans\Config::$serverKey = $gateway->parameters->server_key ?? '';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->transaction,
                'gross_amount' => round($order->final_amount, 2) * 100,
            ),
            'customer_details' => array(
                'first_name' => optional($order->user)->firstname,
                'last_name' => optional($order->user)->lastname,
                'email' => optional($order->user)->email,
//                'phone' => '08111222333',
            ),
        );

        $send['client_key'] = $gateway->parameters->client_key ?? '';
        $send['token'] = \Midtrans\Snap::getSnapToken($params);

        $send['view'] = 'user.payment.midtrans';
        return json_encode($send);
    }

    /**
     * @param $request
     * @param $gateway
     * @param null $order
     * @param null $trx
     * @param null $type
     * @return mixed
     */
    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $url = "https://api.sandbox.midtrans.com/v2/{$order->transaction}/status";
        $serverKey = $gateway->parameters->server_key ?? '';
        $headers = [
            'Content-Type:application/json',
            'Authorization:Basic ' . base64_encode("{$serverKey}:")
        ];
        $response = BasicCurl::curlGetRequestWithHeaders($url, $headers);
        $paymentData = json_decode($response, true);
        if (isset($paymentData['transaction_status']) && ($paymentData['transaction_status'] == 'capture' || $paymentData['transaction_status'] == 'settlement')) {
            if ($paymentData['currency'] == $order->gateway_currency && $paymentData['gross_amount'] == round($order->final_amount, 2) * 100) {
                BasicService::preparePaymentUpgradation($order);

                $data['status'] = 'success';
                $data['msg'] = 'Transaction was successful.';
                $data['redirect'] = route('success');
            } else {
                $data['status'] = 'error';
                $data['msg'] = 'invalid amount.';
                $data['redirect'] = route('failed');
            }
        } elseif (isset($paymentData['transaction_status']) && $paymentData['transaction_status'] == 'pending') {
            $data['status'] = 'error';
            $data['msg'] = 'Your payment is on pending.';
            $data['redirect'] = route('user.home');
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'unexpected error!';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
