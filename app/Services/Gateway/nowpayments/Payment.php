<?php

namespace App\Services\Gateway\nowpayments;

use App\Models\Fund;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $APIkey = $gateway->parameters->api_key ?? '';
        $url = 'https://api.nowpayments.io/v1/';
//        $url = 'https://api-sandbox.nowpayments.io/v1/';

        $postField['price_amount'] = (string)round($order->final_amount, 2);
        $postField['price_currency'] = "USD";
        $postField['pay_currency'] = strtolower($order->gateway_currency);
        $postField['ipn_callback_url'] = "https://nowpayments.io";
        $postField['order_id'] = $order->transaction;
        $postField['order_description'] = "Deposit on " . config('basic.site_title') . " account";


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . 'payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postField),
            CURLOPT_HTTPHEADER => array(
                "x-api-key: $APIkey",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $result = json_decode($response);
        if (isset($result->status) && $result->status == false) {
            $send['error'] = true;
            $send['message'] = $result->message;
            $send['view'] = 'user.payment.crypto';
            return json_encode($send);
        } else {
            $order['btc_wallet'] = $result->pay_address;
            $order['btc_amount'] = $result->pay_amount;
            $order['payment_id'] = $result->payment_id;
            $order->update();
        }


        $send['amount'] = $order->btc_amount;
        $send['sendto'] = $order->btc_wallet;
        $send['img'] = BasicService::cryptoQR($order->btc_wallet, $order->btc_amount);
        $send['currency'] = $order->gateway_currency ?? 'BTC';
        $send['view'] = 'user.payment.crypto';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $APIkey = $gateway->parameters->api_key ?? '';
        $url = 'https://api.nowpayments.io/v1/';
//        $url = 'https://api-sandbox.nowpayments.io/v1/';

        $orderData = Fund::with('gateway')
            ->whereHas('gateway', function ($query) {
                $query->where('code', 'nowpayments');
            })
            ->where('status', 0)
            //->where('transaction', 'GRU83F3AXNJN')
            ->whereNotNull('btc_wallet')
            ->whereNotNull('payment_id')
            ->latest()
            ->get();



        foreach ($orderData as $data) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . 'payment/' . $data->payment_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "x-api-key: $APIkey"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response);

            //echo "<pre>";
            //echo "Transaction ID: ".$data->transaction;
            //echo "<br>";
            //print_r($res);
            echo "</pre>";
            if (isset($res->payment_status) && ($res->payment_status == 'finished' || $res->payment_status == 'waiting')) {
                BasicService::preparePaymentUpgradation($data);
            }


        }
    }
}
