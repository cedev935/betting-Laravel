<?php

namespace App\Services\Gateway\payeer;


use App\Models\Fund;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $m_amount = number_format($order->amount, 2, '.', "");
        $arHash = [
            trim($gateway->parameters->merchant_id),
            $order->transaction,
            $m_amount,
            $order->gateway_currency,
            base64_encode("Pay To $basic->site_title"),
            trim($gateway->parameters->secret_key)
        ];

        $val['m_shop'] = trim($gateway->parameters->merchant_id);
        $val['m_orderid'] = $order->transaction;
        $val['m_amount'] = $m_amount;
        $val['m_curr'] = $order->gateway_currency;
        $val['m_desc'] = base64_encode("Pay To $basic->site_title");
        $val['m_sign'] = strtoupper(hash('sha256', implode(":", $arHash)));
        $val['lang'] = 'en';

        $send['val'] = $val;
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'get';
        $send['url'] = 'https://payeer.com/merchant';

        return json_encode($send);
    }


    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        if (isset($request->m_operation_id) && isset($request->m_sign)) {
            $sign_hash = strtoupper(hash('sha256', implode(":", array(
                $request->m_operation_id,
                $request->m_operation_ps,
                $request->m_operation_date,
                $request->m_operation_pay_date,
                $request->m_shop,
                $request->m_orderid,
                $request->m_amount,
                $request->m_curr,
                $request->m_desc,
                $request->m_status,
                $gateway->parameters->secret_key
            ))));

            if ($request->m_sign != $sign_hash) {
                $data['status'] = 'error';
                $data['msg'] = 'digital signature not matched';
                $data['redirect'] = route('failed');
            } else {
                $order = Fund::where('transaction', $request->m_orderid)->latest()->first();
                if ($request->m_amount == round($order->final_amount,2) && $request->m_curr == $order->gateway_currency && $request->m_status == 'success' && $order->status == 0) {
                    BasicService::preparePaymentUpgradation($order);
                    $data['status'] = 'success';
                    $data['msg'] = 'Transaction was successful.';
                    $data['redirect'] = route('success');


                    return $data;
                } else {
                    $data['status'] = 'error';
                    $data['msg'] = 'transaction was unsuccessful';
                    $data['redirect'] = route('failed');
                    return $data;
                }
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'transaction was unsuccessful';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
