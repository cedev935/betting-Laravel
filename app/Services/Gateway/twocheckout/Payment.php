<?php


namespace App\Services\Gateway\twocheckout;

use App\Models\Fund;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {
        $basic = (object) config('basic');
        $send['val'] = [
            'sid' => $gateway->parameters->merchant_code,
            'mode' => '2CO',
            'li_0_type' => 'product',
            'li_0_name' => $order->transaction ?? $basic->site_title,
            'li_0_product_id' => "{$order->transaction}",
            'li_0_price' => round($order->final_amount, 2),
            'li_0_quantity' => "1",
            'li_0_tangible' => "N",
            'currency_code' => $gateway->currency,
            'demo' => "Y",
        ];
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'post';
        $send['url'] = 'https://www.2checkout.com/checkout/purchase';
        return json_encode($send);
    }

    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {
        $hashSecretWord = $gateway->parameters->secret_key;
        $hashSid = $gateway->parameters->merchant_code;
        $order = Fund::where('transaction', $request->li_0_product_id)->latest()->first();
        $hashTotal = round($order->final_amount, 2);
        $hashOrder = $request->order_number;
        $StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));

        if ($StringToHash != $request->key) {
            BasicService::preparePaymentUpgradation($order);
            $data['status'] = 'success';
            $data['msg'] = 'Transaction was successful.';
            $data['redirect'] = route('success');
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'unsuccessful';
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
