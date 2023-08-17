<?php

namespace App\Services\Gateway\blockchain;



use Facades\App\Services\BasicService;
use Facades\App\Services\BasicCurl;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $apiKey = $gateway->parameters->api_key ?? '';
        $xpubCode = $gateway->parameters->xpub_code ?? '';

        $btcPriceUrl = "https://blockchain.info/ticker";
        $btcPriceResponse = BasicCurl::curlGetRequest($btcPriceUrl);
        $btcPriceResponse = json_decode($btcPriceResponse);
        $btcRate = $btcPriceResponse->USD->last;

        $usd = $order->final_amount;
        $btcamount = $usd / $btcRate;
        $btc = round($btcamount, 8);
        if ($order->btc_amount == 0 || $order->btc_wallet == "") {
            $secret = $order->transaction;
            $callback_url = route('ipn', [$gateway->code, $order->transaction]) . "?invoice_id=" . $order->transaction . "&secret=" . $secret;
            $url = "https://api.blockchain.info/v2/receive?key={$apiKey}&callback=" . urlencode($callback_url) . "&xpub={$xpubCode}";
            $response = BasicCurl::curlGetRequest($url);
            $response = json_decode($response);
            if (@$response->address == '') {
                $send['error'] = true;
                $send['message'] = 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER. ' . $response->message;
            } else {
                $order['btc_wallet'] = $response->address;
                $order['btc_amount'] = $btc;
                $order->update();
            }
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
        $btc = $request->value / 100000000;
        if ($order->btc_amount == $btc && $request->address == $order->btc_wallet && $request->secret == $order->transaction && $request->confirmations > 2 && $order->status == 0) {
            BasicService::preparePaymentUpgradation($order);

            $data['status'] = 'success';
            $data['msg'] = 'Transaction was successful.';
            $data['redirect'] = route('success');
        }else{
            $data['status'] = 'error';
            $data['msg'] = 'Invalid response.';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
