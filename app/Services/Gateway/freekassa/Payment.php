<?php

namespace App\Services\Gateway\freekassa;

use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Order;
use Facades\App\Services\BasicService;

class Payment
{
    public static function prepareData($order, $gateway)
    {

        $merchant_id = trim($gateway->parameters->merchant_id);
        $order_amount = round($order->final_amount, 2);
//        $order_amount = number_format($order->final_amount, 2, '.', "");
        $secret_word = trim($gateway->parameters->secret_word);
        $currency = strtoupper($order->gateway_currency);
        $order_id = $order->transaction;
        $sign = md5($merchant_id . ':' . $order_amount . ':' . $secret_word . ':' . $currency . ':' . $order_id);

        $val['m'] = $merchant_id;
        $val['oa'] = $order_amount;
        $val['o'] = $order_id;
        $val['s'] = $sign;
        $val['currency'] = $currency;
        $val['i'] = '1';
        $val['phone'] = optional($order->user)->phone ?? '+8801741258969';
        $val['em'] = optional($order->user)->email;
        $val['lang'] = 'en';
        $send['val'] = $val;
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'get';
        $send['url'] = 'https://pay.freekassa.ru/';
        return json_encode($send);
    }


    public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
    {

        $ipnrequest = @file_get_contents('php://input');
//        file_put_contents(time().'_freekassa.txt', $ipnrequest);

        if (!in_array(self::getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) {
            $data['status'] = 'error';
            $data['msg'] = 'Hacking attempt!';
            $data['redirect'] = route('failed');
            return $data;
        };

        $merchant_id = trim($gateway->parameters->merchant_id);
        $merchant_secret = trim($gateway->parameters->secret_word2);
        $sign = md5($merchant_id . ':' . $_REQUEST['AMOUNT'] . ':' . $merchant_secret . ':' . $_REQUEST['MERCHANT_ORDER_ID']);


        if ($sign != $_REQUEST['SIGN']) {
            $data['status'] = 'error';
            $data['msg'] = 'wrong sign';
            $data['redirect'] = route('failed');
            return $data;
        }

        if ($_REQUEST['AMOUNT'] == round($order->final_amount, 2) && $request->MERCHANT_ORDER_ID == $order->transaction && $order->status == 0) {
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


    //helper function
    public function getIP()
    {
        if (isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
        return $_SERVER['REMOTE_ADDR'];
    }

}
