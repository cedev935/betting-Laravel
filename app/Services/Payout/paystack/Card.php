<?php

namespace App\Services\Payout\paystack;

use App\Models\PayoutMethod;
use App\Models\VendorPayoutMethod;
use Facades\App\Services\BasicCurl;

class Card
{
	public static function getBank($currencyCode)
	{
		$method = PayoutMethod::where('code', 'paystack')->first();
		$url = 'https://api.paystack.co/bank/?currency=' . strtoupper($currencyCode);
		$SEC_KEY = optional($method->parameters)->Secret_key;
		$headers = [
			'Content-Type: application/json',
			'Authorization: Bearer ' . $SEC_KEY
		];


		$response = BasicCurl::curlGetRequestWithHeaders($url, $headers);
		$result = json_decode($response);

		if (!isset($result->status)) {
			return [
				'status' => 'error',
				'data' => 'Something went wrong try again'
			];
		}

		if ($result->status == 'true') {
			return [
				'status' => 'success',
				'data' => $result->data
			];
		} else {
			return [
				'status' => 'error',
				'data' => $result->message
			];
		}
	}

	public static function payouts($payout)
	{
        $method = PayoutMethod::where('code', 'paystack')->first();

		$api = 'https://api.paystack.co/';
		$SEC_KEY = optional($method->parameters)->Secret_key;
		$headers = [
			'Content-Type: application/json',
			'Authorization: Bearer ' . $SEC_KEY
		];

		$card = new Card();
		$res = $card->createRecipient($api, $headers, $payout);
		if ($res['status'] == 'error') {
			return [
				'status' => 'error',
				'data' => $res['data']
			];
		}

		$recipient_code = $res['data'];
		$url = $api . 'transfer';
		$info = $payout->information;
		$amount = (int)$info->amount->fieldValue;

		$postParam = [
			"source" => 'balance',
			"amount" => $amount,
			"recipient" => $recipient_code,
		];
		$response = BasicCurl::curlPostRequestWithHeaders($url, $headers, $postParam);
		$result = json_decode($response);

		if ($result->status == false) {
			return [
				'status' => 'error',
				'data' => $result->message
			];
		} elseif ($result->status == true) {
			return [
				'status' => 'success',
				'response_id' => $result->data->id
			];
		}

	}

	public static function createRecipient($api, $headers, $payout)
	{
		$url = $api . 'transferrecipient';
		$info = $payout->information;

		$postParam = [
			"type" => $info->type->fieldValue,
			"name" => $info->name->fieldValue,
			"account_number" => $info->account_number->fieldValue,
			"bank_code" => $info->bank_code->fieldValue,
			"currency" => $payout->currency_code,
		];
		$response = BasicCurl::curlPostRequestWithHeaders($url, $headers, $postParam);
		$result = json_decode($response);

		if ($result->status == false) {
			return [
				'status' => 'error',
				'data' => $result->message
			];
		} elseif ($result->status == true) {
			return [
				'status' => 'success',
				'data' => $result->data->recipient_code
			];
		}
	}
}
