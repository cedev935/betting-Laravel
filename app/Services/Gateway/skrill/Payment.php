<?php

namespace App\Services\Gateway\skrill;


use Facades\App\Services\BasicService;

class Payment
{

    /*
     * Skrill Gateway
     */
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $val['pay_to_email'] = trim($gateway->parameters->pay_to_email);
        $val['transaction_id'] = "$order->transaction";
        $val['return_url'] = route('user.addFund');
        $val['return_url_text'] = "Return $basic->site_title";
        $val['cancel_url'] = route('user.addFund');
        $val['status_url'] = route('ipn', [$gateway->code, $order->transaction]);
        $val['language'] = 'EN';
        $val['amount'] = round($order->final_amount,2);
        $val['currency'] = "$order->final_amount";
        $val['detail1_description'] = "$basic->site_title";
        $val['detail1_text'] = "Pay To $basic->site_title";
        $val['logo_url'] = getFile(config('location.logoIcon.path'));
        $send['val'] = $val;
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'post';
        $send['url'] = 'https://www.moneybookers.com/app/payment.pl';
        return json_encode($send);
    }


    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $concatFields = $request->merchant_id
            . $request->transaction_id
            . strtoupper(md5(trim($gateway->parameters->secret_key)))
            . $request->mb_amount
            . $request->mb_currency
            . $request->status;

        if (strtoupper(md5($concatFields)) == $request->md5sig && $request->status == 2 && $request->pay_to_email == trim($gateway->parameters->pay_to_email) && $order->status = '0') {
            BasicService::preparePaymentUpgradation($order);
        }
    }
}
