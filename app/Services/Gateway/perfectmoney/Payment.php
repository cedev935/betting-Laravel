<?php

namespace App\Services\Gateway\perfectmoney;

use Facades\App\Services\BasicService;
use Illuminate\Support\Facades\Auth;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $val['PAYEE_ACCOUNT'] = trim($gateway->parameters->payee_account);
        $val['PAYEE_NAME'] = $basic->site_title ?? 'Photoica';
        $val['PAYMENT_ID'] = "$order->transaction";
        $val['PAYMENT_AMOUNT'] = round($order->amount,2);
        $val['PAYMENT_UNITS'] = "$order->gateway_currency";
        $val['STATUS_URL'] = route('ipn', [$gateway->code, $order->transaction]);
        $val['PAYMENT_URL'] = route('success');
        $val['PAYMENT_URL_METHOD'] = 'POST';
        $val['NOPAYMENT_URL'] = route('failed');
        $val['NOPAYMENT_URL_METHOD'] = 'POST';
        $val['SUGGESTED_MEMO'] = optional($order->user)->username;
        $val['BAGGAGE_FIELDS'] = 'IDENT';
        $send['val'] = $val;
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'post';
        $send['url'] = 'https://perfectmoney.is/api/step1.asp';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $passphrase = strtoupper(md5(trim($gateway->parameters->passphrase)));
        define('ALTERNATE_PHRASE_HASH', $passphrase);
        define('PATH_TO_LOG', '/assets/uploads/');
        $string =
            $request->PAYMENT_ID . ':' . $request->PAYEE_ACCOUNT . ':' .
            $request->PAYMENT_AMOUNT . ':' .$request->PAYMENT_UNITS . ':' .
            $request->PAYMENT_BATCH_NUM . ':' .
            $request->PAYER_ACCOUNT . ':' . ALTERNATE_PHRASE_HASH . ':' .
            $request->TIMESTAMPGMT;

        $hash = strtoupper(md5($string));
        $hash2 = $request->V2_HASH;

        if ($hash == $hash2) {
            $amount = $request->PAYMENT_AMOUNT;
            $unit = $request->PAYMENT_UNITS;
            if ($request->PAYEE_ACCOUNT == trim($gateway->parameters->payee_account) && $unit == $order->gateway_currency && $amount == round($order->amount,2)&& $order->status == '0') {
                BasicService::preparePaymentUpgradation($order);
            }
        }
    }
}
