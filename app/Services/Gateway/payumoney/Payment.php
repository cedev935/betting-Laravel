<?php

namespace App\Services\Gateway\payumoney;


use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        $send['val'] = [
            'key' => $gateway->parameters->merchant_key ?? '',
            'txnid' => $order->transaction,
            'amount' => round($order->final_amount,2),
            'firstname' => optional($order->user)->username ?? 'SMM Panel',
            'email' => optional($order->user)->email ?? '',
            'productinfo' => $order->transaction ?? 'Order',
            'surl' => route('ipn', [$gateway->code, $order->transaction]),
            'furl' => route('failed'),
            'service_provider' => $basic->site_title ?? 'SMM Panel',
        ];
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= $send['val'][$hash_var] ?? '';
            $hash_string .= '|';
        }
        $hash_string .= $gateway->parameters->salt ?? '';

        $send['val']['hash'] = strtolower(hash('sha512', $hash_string));
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'post';
//        $send['url'] = 'https://test.payu.in/_payment'; //test purpose
        $send['url'] = 'https://secure.payu.in/_payment';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        if (isset($request->status) && $request->status == 'success') {
            if (($gateway->parameters->merchant_key ?? '') == $request->key) {
                if ($order->transaction == $request->txnid) {
                    if (round($order->final_amount,2) <= $request->amount) {
                        BasicService::preparePaymentUpgradation($order);

                        $data['status'] = 'success';
                        $data['msg'] = 'Transaction was successful.';
                        $data['redirect'] = route('success');
                    } else {
                        $data['status'] = 'error';
                        $data['msg'] = 'invalid amount.';
                        $data['redirect'] = route('failed');
                    }
                } else {
                    $data['status'] = 'error';
                    $data['msg'] = 'invalid trx id.';
                    $data['redirect'] = route('failed');
                }
            } else {
                $data['status'] = 'error';
                $data['msg'] = 'deposit into wrong account.';
                $data['redirect'] = route('failed');
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'unexpected error.';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
