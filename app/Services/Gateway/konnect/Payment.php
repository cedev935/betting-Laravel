<?php

namespace App\Services\Gateway\konnect;

use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;


class Payment
{
    public static function prepareData($order, $gateway)
    {
        $postParam["receiverWalletId"] = $gateway->parameters->receiver_wallet_Id ?? '6399ed9208ec811bcda4af6e';
        $postParam["token"] = $order->gateway_currency; // "TND" "EUR" "USD"

        if (in_array($postParam["token"], array("EUR", "GBP", "USD"))) {
            $postParam["amount"] = (int)$order->final_amount * 100;
        } else {
            $postParam["amount"] = (int)$order->final_amount;
        }

        $postParam["type"] = "immediate";
        $postParam["description"] = "Payment with konnect";
        $postParam["lifespan"] = 10;
        $postParam["feesIncluded"] = true;
        $postParam["firstName"] = optional($order->user)->firstname;
        $postParam["lastName"] = optional($order->user)->lastname;
        $postParam["phoneNumber"] = optional($order->user)->lastname;
        $postParam["email"] = optional($order->user)->email;
        $postParam["orderId"] = $order->transaction;
        $postParam["webhook"] = route('ipn', [$gateway->code, $order->transaction]);
        $postParam["silentWebhook"] = true;
        $postParam["successUrl"] = route('success');
        $postParam["failUrl"] = route('failed');
        $postParam["checkoutForm"] = true;
        $postParam["acceptedPaymentMethods"] = ["wallet", "bank_card", "e-DINAR"];

        ////////// Live Mode
        $baseUrl = "https://api.konnect.network/api/v2/";

        //////////////////// Sandbox
//        $baseUrl = "https://api.preprod.konnect.network/api/v2/";

        $apiKey = $gateway->parameters->api_key ?? '6399ed9208ec811bcda4af6d:9WNA3dfjmDq6ynKb5RsRTYM7dIpq9';
        $headers = [
            'Content-Type:application/json',
            'x-api-key:' . "$apiKey"
        ];

        $result = BasicCurl::curlPostRequestWithHeaders($baseUrl . 'payments/init-payment', $headers, $postParam);
        $response = json_decode($result);
        if (isset($response->payUrl)) {
            $order->btc_wallet = $response->paymentRef;
            $order->save();

            $send['redirect'] = true;
            $send['redirect_url'] = $response->payUrl;
        } else {

            $send['error'] = true;
            $send['message'] = "Error: " . @$response->errors[0]->message ?? 'Something Went wrong';
        }
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $paymentId = $request->payment_ref;
        //// Live Mode
        $baseUrl = "https://api.konnect.network/api/v2/";
        ///// Sandbox
//        $baseUrl = "https://api.preprod.konnect.network/api/v2/";

        $apiKey = $gateway->parameters->api_key ?? '6399ed9208ec811bcda4af6d:9WNA3dfjmDq6ynKb5RsRTYM7dIpq9';

        $headers = [
            'Content-Type:application/json',
            'x-api-key:' . "$apiKey"
        ];

        $result = BasicCurl::curlGetRequestWithHeaders($baseUrl . 'payments/' . $paymentId, $headers);
        $response = json_decode($result);

        if (in_array($order["gateway_currency"], array("EUR", "GBP", "USD"))) {
            $convertedOrderAmount = (int)$order->final_amount * 100;
        } else {
            $convertedOrderAmount = (int)$order->final_amount;
        }
        if ($response->payment->amount == $convertedOrderAmount && $response->payment->status == 'completed') {
            BasicService::preparePaymentUpgradation($order);

            $data['status'] = 'success';
            $data['msg'] = 'Transaction was successful.';
            $data['redirect'] = route('success');
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'Invalid response.';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
