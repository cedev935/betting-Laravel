<?php

namespace App\Services\Gateway\cashonexHosted;

use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;


class Payment
{
    public static function prepareData($order, $gateway)
    {
        $idempotency_key = $gateway->parameters->idempotency_key??'727649-0h76ac-467573-fxoxli-141433-c5ugg1';
        $salt = $gateway->parameters->salt??'67a8d2c1548c1ddb616bdc27e31fbd5e385f7872204043df7219498f08e4dcda';

        $headers = [
            'Content-Type: application/json',
            "Idempotency-Key: $idempotency_key",
        ];

        $postParam = [
            "salt" => $salt,
            "last_name" => optional($order->user)->lastname,
            "first_name" => optional($order->user)->firstname,
            "email" => optional($order->user)->email??'email@gmail.com',
            "phone" => optional($order->user)->phone??'9999999999',
            "address" => optional($order->user)->address??'123, address',
            "city" => optional($order->user)->city??'City',
            "state" => optional($order->user)->city??'State',
            "country" => optional($order->user)->country??'GB',
            "zip_code" => optional($order->user)->zip_code??'90210',
            "amount" => round($order->final_amount ,2),
            "currency" => $order->gateway_currency,
            "orderid" => $order->transaction,
            "clientip" => request()->ip(),
            "redirect_url" => route('success'),
            "webhook_url" => route('ipn', [$gateway->code, $order->transaction])
        ];

        $url = "https://cashonex.com/api/rest/payment";
        $result = BasicCurl::curlPostRequestWithHeadersJson($url, $headers, $postParam);
        $response = json_decode($result);


        if (isset($response->success) && $response->success == true) {
            $order->btc_wallet = @$response->data->paymentId;
            $order->update();

            $send['redirect'] = true;
            $send['redirect_url'] = $response->data->redirectUrl;
        } else {
            $send['error'] = true;
            $send['message'] = 'Unexpected Error!';
        }
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        if ($request['transaction_status'] == 'APPROVED' && $request['amount'] == round($order->final_amount ,2)) {
            BasicService::preparePaymentUpgradation($order);
        }

    }
}
