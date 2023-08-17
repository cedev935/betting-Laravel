<?php

namespace App\Services\Gateway\binance;

use Facades\App\Services\BasicCurl;
use Facades\App\Services\BasicService;
use Illuminate\Support\Str;


class Payment
{
	public static function prepareData($order, $gateway)
	{
		$url = "https://bpay.binanceapi.com/binancepay/openapi/v2/order";
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$nonce = '';
		for ($i = 1; $i <= 32; $i++) {
			$pos = mt_rand(0, strlen($chars) - 1);
			$char = $chars[$pos];
			$nonce .= $char;
		}
//		$merchantTradeNo = mt_rand(982538, 9825382937292);
		$merchantTradeNo = $order->transaction;

		$timestamp = round(microtime(true) * 1000);
		// Request body
		$request = array(
			"env" => array(
				"terminalType" => "WEB"
			),
			"merchantTradeNo" => $merchantTradeNo,
			"orderAmount" => round($order->final_amount, 2),
			"currency" => $order->gateway_currency,
			"goods" => array(
				"goodsType" => "01",
				"goodsCategory" => "D000",
				"referenceGoodsId" => "7876763A3B",
				"goodsName" => config('basic.site_title')." Payment",
				"goodsDetail" => "Payment to ".config('basic.site_title')
			),
			'returnUrl' => route('ipn', [$gateway->code, $merchantTradeNo]),
			'webhookUrl' => route('ipn', [$gateway->code, $merchantTradeNo]),
			'cancelUrl' => route('failed'),
		);

		$json_request = json_encode($request);
		$payload = $timestamp . "\n" . $nonce . "\n" . $json_request . "\n";
		$binance_pay_key = $gateway->parameters->mercent_api_key;
		$binance_pay_secret = $gateway->parameters->mercent_secret;
		$signature = strtoupper(hash_hmac('SHA512', $payload, $binance_pay_secret));

		$headers = array();
		$headers[] = "Content-Type: application/json";
		$headers[] = "BinancePay-Timestamp: $timestamp";
		$headers[] = "BinancePay-Nonce: $nonce";
		$headers[] = "BinancePay-Certificate-SN: $binance_pay_key";
		$headers[] = "BinancePay-Signature: $signature";

		$response = self::curlOrderRequest($url, $headers, $json_request);


		$result = json_decode($response);

		if (isset($result)) {
			if (isset($result->data)) {
				$send['redirect'] = true;
				$send['redirect_url'] = $result->data->checkoutUrl;
			} else {
				$send['error'] = true;
                $send['message'] = 'Unexpected Error! Please Try Again';
			}
		} else {
			$send['error'] = true;
			$send['message'] = 'Unexpected Error! Please Try Again';
		}
		return json_encode($send);
	}

	public static function ipn($request, $gateway, $order = null, $trx = null, $type = null)
	{
		$url = "https://bpay.binanceapi.com/binancepay/openapi/v2/order/query";
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$nonce = '';
		for ($i = 1; $i <= 32; $i++) {
			$pos = mt_rand(0, strlen($chars) - 1);
			$char = $chars[$pos];
			$nonce .= $char;
		}
		$timestamp = round(microtime(true) * 1000);
		$request = array(
			"merchantTradeNo" => $trx,
		);

		$json_request = json_encode($request);
		$payload = $timestamp . "\n" . $nonce . "\n" . $json_request . "\n";
		$binance_pay_key = $gateway->parameters->mercent_api_key;
		$binance_pay_secret = $gateway->parameters->mercent_secret;
		$signature = strtoupper(hash_hmac('SHA512', $payload, $binance_pay_secret));

		$headers = array();
		$headers[] = "Content-Type: application/json";
		$headers[] = "BinancePay-Timestamp: $timestamp";
		$headers[] = "BinancePay-Nonce: $nonce";
		$headers[] = "BinancePay-Certificate-SN: $binance_pay_key";
		$headers[] = "BinancePay-Signature: $signature";

		$response = self::curlOrderRequest($url, $headers, $json_request);
		$result = json_decode($response);


		if (isset($result)) {
			if ($result->status == 'SUCCESS') {
				if (isset($result->data)) {
					if ($result->data->status = 'PAID') {
						BasicService::prepareOrderUpgradation($order);
						$data['status'] = 'success';
						$data['msg'] = 'Transaction was successful.';
						$data['redirect'] = route('success');
                        return $data;
					}
				}
			} else {
				$data['status'] = 'error';
				$data['msg'] = 'unexpected error!';
				$data['redirect'] = route('failed');
			}
		}
		return $data;
	}


    public static function curlOrderRequest($url, $headers, $json_request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
