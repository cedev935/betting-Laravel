<?php

namespace App\Services\Payout\perfectmoney;

use App\Models\PayoutMethod;
use App\Models\VendorPayoutMethod;
use Facades\App\Services\BasicCurl;

class Card
{
	public static function payouts($payout)
	{
        $method = PayoutMethod::where('code', 'perfectmoney')->first();

		$AccountID = optional($method->parameters)->Account_ID;
		$PassPhrase = optional($method->parameters)->Passphrase;
		$Payer_Account = optional($method->parameters)->Payer_Account;

		$info = $payout->information;
		$amount = $info->amount->fieldValue;

		$params = array('AccountID' => $AccountID,
			'PassPhrase' => '45P7GN1T8TlRfMRAPCqLArVHz',
			'Payer_Account' => $PassPhrase, // Admin ID - FROM WALLET
			'Payee_Account' => $Payer_Account, // User Id- TO WALLET
			'Amount' => $amount, // AMOUNT AFTER CALCULATION, in USD
			'PAY_IN' => 1, // Keep This
			'PAYMENT_ID' => 'abir 551211', // TRX NUM
		);
		$query = http_build_query($params);
		$url = 'https://perfectmoney.is/acct/confirm.asp?' . $query;
		$f = fopen($url, 'rb');

		if ($f === false) {
			echo 'error openning url';
			exit();
		}

		$out = array();
		$out = "";
		while (!feof($f)) $out .= fgets($f);
		fclose($f);

		if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)) {
			echo 'Ivalid output';
			exit;

			$ar = "";

			foreach ($result as $item) {
				$ar .= "$item[1]:$item[2],";
			}
		}

		if (isset($result[0]) && $result[0][1] == 'ERROR') {
			return [
				'status' => 'error',
				'data' => $result[0][2]
			];
		} else {
			return [
				'status' => 'success',
				'response_id' => null
			];
		}
	}
}
