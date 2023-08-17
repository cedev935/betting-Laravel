<?php

namespace App\Services\Payout\flutterwave;

use App\Models\PayoutMethod;
use Facades\App\Services\BasicCurl;

class Card
{
    public static function getBank($countryCode)
    {
        $method = PayoutMethod::where('code', 'flutterwave')->first();
        $url = 'https://api.flutterwave.com/v3/banks/' . strtoupper($countryCode);
        $SEC_KEY = optional($method->parameters)->Secret_Key;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $SEC_KEY
        ];


        $response = BasicCurl::curlGetRequestWithHeaders($url, $headers);
        $result = json_decode($response);

        if (!isset($result->status)) {
            return [
                'status' => 'error',
                'data' => 'Something went wrong try again'
            ];
        }

        if ($result->status == 'error') {
            return [
                'status' => 'error',
                'data' => $result->message
            ];
        } elseif ($result->status == 'success') {
            return [
                'status' => 'success',
                'data' => $result->data
            ];
        }
    }

    public static function payouts($payout)
    {
        $method = PayoutMethod::where('code', 'flutterwave')->first();

        $url = 'https://api.flutterwave.com/v3/transfers';
        $SEC_KEY = optional($method->parameters)->Secret_Key;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $SEC_KEY
        ];

        $postParam['currency'] = $payout->currency_code;
        foreach ($payout->information as $key => $info) {
            $postParam[$key] = $info->fieldValue;
        }
        if ($payout->meta_field) {
            foreach ($payout->meta_field as $key => $info) {
                $postParam['meta'][$key] = $info->fieldValue;
            }
        }

        $postParam['amount'] = (int)$postParam['amount'];
        $postParam['callback_url'] = route('payout', $method->code);

        $response = BasicCurl::curlPostRequestWithHeaders($url, $headers, $postParam);
        $result = json_decode($response);

        if (isset($result) && $result->status == 'error') {
            return [
                'status' => 'error',
                'data' => $result->message
            ];
        } elseif (isset($result) && $result->status == 'success') {
            return [
                'status' => 'success',
                'response_id' => $result->data->id
            ];
        }
    }
}
