<?php

namespace App\Services\Payout\binance;

use App\Models\PayoutMethod;
use App\Models\VendorPayoutMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Card
{
    public static function payouts($payout)
    {
        $method = PayoutMethod::where('code', 'binance')->first();

        $info = $payout->information;

        if ($method->environment == 'live') {
            $api = 'https://api.binance.com/sapi/v1/';
        } else {
            $api = 'https://testnet.binance.com/sapi/v1/';
        }

        $API_Key = optional($method->parameters)->API_Key;
        $KEY_Secret = optional($method->parameters)->KEY_Secret;

        $microtime = round(microtime(true) * 1000);
        $withoutF = preg_replace('/(0)\.(\d+) (\d+)/', '$3$1$2', $microtime);

        $coin = $payout->currency_code;
        $network = $info->network->fieldValue;
        $address = $info->address->fieldValue;
        $amount = (int)$info->amount->fieldValue;
        $recvWindow = 60000;

        $params = [
            'coin' => $coin,
            'network' => $network,
            'address' => $address,
            'amount' => $amount,
            'recvWindow' => $recvWindow,
            'timestamp' => $withoutF
        ];

        $card = new Card();
        $query = $card->buildQuery($params);

        $signature = hash_hmac('sha256', $query, $KEY_Secret);

        $url = $api . "capital/withdraw/apply?coin=$coin&network=$network&address=$address&amount=$amount&recvWindow=$recvWindow&timestamp=$withoutF&signature=$signature";

        $response = self::curlRequestWithHeaders($url, $API_Key, 'POST');
        $result = json_decode($response);
        if (!isset($result->msg)) {
            return [
                'status' => 'error',
                'data' => 'Something went wrong'
            ];
        }
        if (isset($result->msg)) {
            return [
                'status' => 'error',
                'data' => $result->msg
            ];
        }
        if (isset($result->id)) {
            return [
                'status' => 'success',
                'response_id' => $result->id
            ];
        }

    }


    public static function getStatus()
    {
        $method = PayoutMethod::where('code', 'binance')->first();

        if ($method->environment == 'live') {
            $api = 'https://api.binance.com/sapi/v1/';
        } else {
            $api = 'https://testnet.binance.com/sapi/v1/';
        }

        $API_Key = optional($method->parameters)->API_Key;
        $KEY_Secret = optional($method->parameters)->KEY_Secret;

        $microtime = round(microtime(true) * 1000);
        $withoutF = preg_replace('/(0)\.(\d+) (\d+)/', '$3$1$2', $microtime);
        $startTime = preg_replace('/(0)\.(\d+) (\d+)/', '$3$1$2', Carbon::now()->subDays(90)->getPreciseTimestamp(3));

        $params = [
            'startTime' => $startTime,
            'timestamp' => $withoutF,
        ];

        $card = new Card();
        $query = $card->buildQuery($params);

        $signature = hash_hmac('sha256', $query, $KEY_Secret);

        $endTime = Carbon::now();
        $url = $api . "capital/withdraw/history?startTime=$startTime&timestamp=$withoutF&signature=$signature";

        $response = self::curlRequestWithHeaders($url, $API_Key, 'GET');
        $result = json_decode($response);

        if (isset($result)) {
            return $result;
        }

    }

    public function buildQuery(array $params)
    {
        $query_array = array();
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $query_array = array_merge($query_array, array_map(function ($v) use ($key) {
                    return urlencode($key) . '=' . urlencode($v);
                }, $value));
            } else {
                $query_array[] = urlencode($key) . '=' . urlencode($value);
            }
        }
        return implode('&', $query_array);
    }


    public static function curlRequestWithHeaders($url, $api_key, $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-MBX-APIKEY: ' . $api_key
            ),
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
