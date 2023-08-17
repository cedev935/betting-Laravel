<?php

namespace App\Services\Gateway\peachpayments;

use Facades\App\Services\BasicService;


class Payment
{
    public static function prepareData($order, $gateway)
    {
        $Entity_ID = trim($gateway->parameters->Entity_ID);
        $amount = trim(round($order->final_amount));
        $currency = trim(strtoupper($order->gateway_currency));
        if(env('APP_DEBUG') =='true'){
            $url = "https://test.oppwa.com/v1/checkouts";
        }else{
            $url = "https://oppwa.com/v1/checkouts";
        }
        $data = "entityId=$Entity_ID" .
            "&amount=$amount" .
            "&currency=$currency" .
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer '.$gateway->parameters->Authorization_Bearer)); // client
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($responseData);

        $order->btc_wallet = $result->id;
        $order->save();
        $send['view'] = 'user.payment.peachpayments';
        $send['checkoutId'] = $result->id;

        $send['url'] = route('ipn', [$gateway->code, $order->transaction]);
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {

        $id = $request->id;
        if(env('APP_DEBUG') =='true'){
            $url = "https://test.oppwa.com/v1/checkouts/$id/payment";
        }else{
            $url = "https://oppwa.com/v1/checkouts/$id/payment";
        }
        $url .= "?entityId=".$gateway->parameters->Entity_ID;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer '.$gateway->parameters->Authorization_Bearer));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData);
        $order->response = $response;
        $order->save();

        if(@$response->result->code == '000.100.110'){
            BasicService::preparePaymentUpgradation($order);
            $data['status'] = 'success';
            $data['msg'] = 'Transaction was successful.';
            $data['redirect'] = route('success');
        }else{
            $data['status'] = 'error';
            $data['msg'] = @$response->result->description;
            $data['redirect'] = route('failed');
        }
        return $data;

    }
}
