<?php

namespace App\Services\Gateway\swagger;

use App\Models\Fund;
use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $val['account'] =  $gateway->parameters->MAGUA_PAY_ACCOUNT;
        $val['order_id'] = $order->transaction;
        $val['amount'] = (int)round($order->final_amount);
        $val['currency'] = $order->gateway_currency;
        $val['recurrent'] = false;
        $val['purpose'] = "Online Payment";
        $val['customer_first_name'] = str_replace('.', '', optional($order->user)->firstname) ?? "John";
        $val['customer_last_name'] = optional($order->user)->lastname ?? "Doe";
        $val['customer_address'] = optional($order->user)->address ?? "10 Downing Street";
        $val['customer_city'] = optional($order->user)->city ?? "London";
        $val['customer_zip_code'] = optional($order->user)->zip_code ?? "121165";
        $val['customer_country'] = "GB";
        $val['customer_phone'] = optional($order->user)->phone ?? "+79000000000";
        $val['customer_email'] = optional($order->user)->email ?? "johndoe@mail.com";

        $val['customer_ip_address'] = request()->ip();
        $val['merchant_site'] = url('/');

        $val['success_url'] = route('success');
        $val['fail_url'] = route('failed');
        $val['callback_url'] = route('ipn', $gateway->code);
        $val['status_url'] = route('ipn', $gateway->code);

        $url = "https://api-gateway.magua-pay.com/initPayment";
        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Basic ' . base64_encode($gateway->parameters->MerchantKey . ":" . $gateway->parameters->Secret);

        $response = BasicCurl::curlPostRequestWithHeaders($url, $header, $val);

        $response = json_decode($response);
        if (isset($response->form_url)) {
            $send['redirect'] = true;
            $send['redirect_url'] = $response->form_url;
        } else {
            $send['error'] = true;
            $send['message'] = "Invalid Request";
        }
        return json_encode($send);

    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $order = Fund::where('transaction', $request->orderId)->orderBy('id', 'DESC')->first();
        if ($order) {
            if ($request->status == 2 && $request->currency == $order->gateway_currency && ($request->amount == (int)round($order->final_amount)) && $order->status == 0) {
                BasicService::preparePaymentUpgradation($order);
            }
        }
    }
}
