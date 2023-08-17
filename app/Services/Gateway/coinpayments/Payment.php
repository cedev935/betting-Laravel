<?php

namespace App\Services\Gateway\coinpayments;

use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $isCrypto = (checkTo($gateway->currencies, $order->gateway_currency) == 1) ? true : false;

        if ($isCrypto == false) {
            $val['merchant'] = $gateway->parameters->merchant_id ?? '';
            $val['item_name'] = 'Payment to ' . $basic->site_title;
            $val['currency'] = $order->gateway_currency;
            $val['currency_code'] = $order->gateway_currency;
            $val['amountf'] = $order->final_amount;
            $val['ipn_url'] = route('ipn', [$gateway->code, $order->transaction]);
            $val['custom'] = $order->transaction;
            $val['amount'] = $order->final_amount;
            $val['return'] = route('ipn', [$gateway->code, $order->transaction]);
            $val['cancel_return'] = route('failed');
            $val['notify_url'] = route('ipn', [$gateway->code, $order->transaction]);
            $val['success_url'] = route('success');
            $val['cancel_url'] = route('failed');
            $val['cmd'] = '_pay_simple';
            $val['want_shipping'] = 0;
            $val['buyer_email'] = optional($order->user)->email ?? 'hello@example.com';
            $send['val'] = $val;
            $send['view'] = 'user.payment.redirect';
            $send['method'] = 'post';
            $send['url'] = 'https://www.coinpayments.net/index.php';
        } else {
            if ($order->btc_amount == 0 || $order->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($gateway->parameters->private_key, $gateway->parameters->public_key);
                $callbackUrl = route($gateway->extra_parameters->callback, $gateway->code);

                $req = array(
                    'amount' => $order->final_amount,
                    'currency1' => 'USD',
                    'currency2' => $order->gateway_currency,
                    'custom' => $order->transaction,
                    'ipn_url' => $callbackUrl,
                    'buyer_email' => optional($order->user)->email ?? 'hello@example.com',
                );

                $result = $cps->CreateTransaction($req);

                if ($result['error'] == 'ok') {
                    $btc = sprintf('%.08f', $result['result']['amount']);
                    $wallet = $result['result']['address'];
                    $order['btc_wallet'] = $wallet;
                    $order['btc_amount'] = $btc;
                    $order->update();


                    $send['amount'] = $order->btc_amount;
                    $send['sendto'] = $order->btc_wallet;

                    $send['img'] = BasicService::cryptoQR($order->btc_wallet, $order->btc_amount);
                    $send['currency'] = $order->gateway_currency ?? 'BTC';
                    $send['view'] = 'user.payment.crypto';

                } else {
                    $send['error'] = true;
                    $send['message'] = $result['error'];
                }
            }
        }

        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $isCrypto = (checkTo($gateway->currencies, $order->gateway_currency) == 1) ? true : false;

        $amount1 = floatval($request->amount1) ?? 0;
        $amount2 = floatval($request->amount2) ?? 0;
        $status = $request->status;

        if ($status >= 100 || $status == 2) {
            if ($order->gateway_currency == $request->currency1 && $order->final_amount <= $amount1 && $gateway->parameters->merchant_id == $request->merchant && $order->status == '0') {
                BasicService::preparePaymentUpgradation($order);
            }
            elseif ($order->gateway_currency == $request->currency2 && $order->final_amount <= $amount2 && $gateway->parameters->merchant_id == $request->merchant && $order->status == '0') {
                BasicService::preparePaymentUpgradation($order);
            }
            else {
                $data['status'] = 'error';
                $data['msg'] = 'Invalid amount.';
                $data['redirect'] = route('failed');
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'Invalid response.';
            $data['redirect'] = route('failed');
        }

        return $data;
    }
}
