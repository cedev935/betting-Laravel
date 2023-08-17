<?php

namespace App\Services\Gateway\mypay;


use App\Models\Fund;
use Facades\App\Services\BasicService;
use Facades\App\Services\BasicCurl;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $API_KEY = $gateway->parameters->api_key ?? '';
        $UserName = $gateway->parameters->merchant_username ?? '';
        $Password = $gateway->parameters->merchant_api_password ?? '';
        $MerchantId = $gateway->parameters->merchant_id ?? '';


        // Test Credentials
        // $url = "https://testapi.mypay.com.np/api/use-mypay-payments";
        // Live Credentials
        $url = "https://smartdigitalnepal.com/api/use-mypay-payments";

        $headers = [
            'Content-Type: application/json',
            "API_KEY: $API_KEY",
        ];

        $postParam = [
            "Amount" => round($order->final_amount),
            "OrderId" => $order->transaction,
            "UserName" => "$UserName",
            "Password" => "$Password",
            "MerchantId" => "$MerchantId"
        ];

        $result = BasicCurl::curlPostRequestWithHeadersJson($url, $headers, $postParam);
        $response = json_decode($result);


        if (@$response->status == false) {
            $send['error'] = true;
            $send['message'] = 'PLEASE TRY LATER. ' . @$response->Message;
        } else {
            $order['referenceno'] = $response->MerchantTransactionId;
            $order->update();

            $send['redirect'] = true;
            $send['redirect_url'] = $response->RedirectURL;
        }

        return json_encode($send);

    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
//        {"merchant_username":"gaming.center","merchant_api_password":"RVJT5WIY43J9285","merchant_id":"MER25851801","api_key":"9JRZYZ+oxl2A+ZuoXfgQZiPdiMehRfbDuAQK86nopPb041KGJp+TTQO/pUMEMPDh"}

        $API_KEY = $gateway->parameters->api_key ?? '';
        $UserName = $gateway->parameters->merchant_username ?? '';
        $Password = $gateway->parameters->merchant_api_password ?? '';
        $MerchantId = $gateway->parameters->merchant_id ?? '';

        $orderData = Fund::with('gateway')
            ->whereHas('gateway', function ($query) {
                $query->where('code', 'mypay');
            })
            ->where('status', 0)
            ->whereNotNull('referenceno')
            ->latest()
            ->get();


     //   $url = 'https://testapi.mypay.com.np/api/use-mypay-payments-status';
        $url = "https://smartdigitalnepal.com/api/use-mypay-payments-status";

        $headers = [
            'Content-Type: application/json',
            "API_KEY: $API_KEY",
        ];

        foreach ($orderData as $data) {
            $postParam['MerchantTransactionId']= $data->referenceno;
            $result = BasicCurl::curlPostRequestWithHeadersJson($url, $headers, $postParam);
            $response = json_decode($result);
            if(isset($response) && $response->Status == 1){
                BasicService::preparePaymentUpgradation($data);
            }
        }

    }
}
