<?php

namespace App\Services\Payout\coinbase;

use App\Models\PayoutMethod;
use App\Models\VendorPayoutMethod;
use Facades\App\Services\BasicCurl;
use Illuminate\Support\Facades\Http;

class Card
{
    public static function payouts($payout)
    {
        $card = new Card();

        $method = PayoutMethod::where('code', 'coinbase')->first();

        $SEC_KEY = optional($method->parameters)->API_Secret;
        $API_Key = optional($method->parameters)->API_Key;
        $Api_Passphrase = optional($method->parameters)->Api_Passphrase;
        $info = $payout->information;

        if ($method->environment == 0) {
            $uri = "https://api.exchange.coinbase.com/withdrawals/crypto";
        } else {
            $uri = "https://api-public.sandbox.exchange.coinbase.com/withdrawals/crypto";
        }

        $time = time();
        $body = [
            'amount' => $info->amount->fieldValue,
            'currency' => $payout->currency_code,
            'crypto_address' => $info->crypto_address->fieldValue,
        ];
        $sign = base64_encode(hash_hmac("sha256", $time . 'POST' . '/withdrawals/crypto' . json_encode($body), base64_decode($SEC_KEY), true));
        $response = Http::withHeaders($card->getHeaders($sign, $time, $API_Key, $Api_Passphrase))->post($uri, $body);
        $result = json_decode($response->body());

        if (isset($result->message)) {
            return [
                'status' => 'error',
                'data' => $result->message
            ];
        } else {
            return [
                'status' => 'success',
            ];
        }
    }

    protected function getHeaders($sign, $time, $API_Key, $Api_Passphrase)
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cb-access-key' => $API_Key,
            'cb-access-passphrase' => $Api_Passphrase,
            'cb-access-sign' => $sign,
            'cb-access-timestamp' => $time,
        ];
    }
}
