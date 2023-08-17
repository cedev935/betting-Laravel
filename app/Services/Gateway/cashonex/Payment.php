<?php

namespace App\Services\Gateway\cashonex;

use Facades\App\Services\BasicCurl;


class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object)config('basic');
        $val['name'] = optional($order->user)->username ?? $basic->site_title;
        $val['amount'] = round($order->final_amount ,2);
        $val['currency'] = $order->gateway_currency;
        $send['val'] = $val;
        $send['view'] = 'user.payment.cashonex';
        $send['method'] = 'post';
        $send['url'] = route('ipn', [$gateway->code, $order->transaction]);
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $idempotency_key = $gateway->parameters->idempotency_key;
        $salt = $gateway->parameters->salt;
        $request->validate( [
            'name' => 'required',
            'cardNumber' => 'required',
            'cardExpiry' => 'required',
            'cardCVC' => 'required'
        ],[
            'cardCVC.required' => "The card CVC field is required."
        ]);



        $card_number = $request->cardNumber;
        $exp = $request->cardExpiry;
        $cvc = $request->cardCVC;

        $exp = $pieces = explode("/", $_POST['cardExpiry']);
        $expiry_year = trim($exp[1]);
        $expiry_month = trim($exp[0]);
        $amount = round($order->final_amount ,2);
        $headers = [
            'Content-Type: application/json',
            "Idempotency-Key: $idempotency_key",
        ];

        $postParam = [
            "salt" => $salt,
            "first_name" => optional($order->user)->firstname,
            "last_name" => optional($order->user)->lastname,
            "email" => optional($order->user)->email??'email@gmail.com',
            "phone" => optional($order->user)->phone??'9999999999',
            "address" => optional($order->user)->address??'123, address',
            "city" => optional($order->user)->city??'City',
            "state" => optional($order->user)->city??'State',
            "country" => optional($order->user)->country??'GB',
            "zip_code" => optional($order->user)->zip_code??'90210',
            "amount" => $amount,
            "currency" => $order->gateway_currency,
            "pay_by" => "VISA",
            "card_name" => $request->name,
            "card_number" => $card_number,
            "cvv_code" => $cvc,
            "expiry_year" => $expiry_year,
            "expiry_month" => $expiry_month,
            "orderid" => $order->transaction,
            "clientip" => request()->ip(),
            "redirect_url" => route('success'),
            "webhook_url" => route('paymentCashonex')
        ];

        $url = "https://cashonex.com/api/rest/payment";
        $result = BasicCurl::curlPostRequestWithHeadersJson($url, $headers, $postParam);
        $response = json_decode($result);
        if (isset($response->success) && $response->success == true) {
            $order->btc_wallet = @$response->data->paymentId;
            $order->update();
            $data['status'] = 'success';
            $data['msg'] = ' Payment Proceed.';
            $data['redirect'] = $response->data->redirectUrl;
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'Unsuccessful transaction.';
            $data['redirect'] = route('failed');
        }

        return $data;

    }
}
