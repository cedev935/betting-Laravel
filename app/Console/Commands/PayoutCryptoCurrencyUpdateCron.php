<?php

namespace App\Console\Commands;

use App\Models\Configure;
use App\Models\PayoutMethod;
use App\Services\BasicCurl;
use Illuminate\Console\Command;

class PayoutCryptoCurrencyUpdateCron extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'payout-crypto-currency:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'A command to payout crypto currency conversion rate update.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$basicControl = Configure::first();
		$coin_market_cap_auto_update = $basicControl->coin_market_cap_auto_update;
		$endpoint = 'live';
		$source = 'USD';
		$currency_layer_access_key = $basicControl->currency_layer_access_key;
		$currency_layer_url = "http://api.currencylayer.com";

		if ($coin_market_cap_auto_update == 1) {
			$coin_market_cap_app_key = $basicControl->coin_market_cap_app_key;
			$baseCurrency = $basicControl->base_currency;
			$baseCurrencyAPIUrl = "$currency_layer_url/$endpoint?access_key=$currency_layer_access_key&source=$source&currencies=$baseCurrency";
			$baseCurrencyConvert = BasicCurl::curlGetRequest($baseCurrencyAPIUrl);
			$baseCurrencyConvert = json_decode($baseCurrencyConvert);
			if (empty($baseCurrencyConvert->quotes)) {
				$usdToBase = 1.00;
			} else {
				$usdToBase = $baseCurrencyConvert->quotes->{$source . $baseCurrency};
			}
			$payoutCurrencies = PayoutMethod::where('is_automatic', 1)->where('code', 'coinbase')->where('is_auto_update', 1)->pluck('supported_currency')->toArray();
			$updateForMethods = PayoutMethod::where('is_automatic', 1)->where('code', 'coinbase')->where('is_auto_update', 1)->get();

			$currencyLists = array();
			foreach ($payoutCurrencies as $currency) {
				foreach ($currency as $singleCurrency) {
					$currencyLists[] = $singleCurrency;
				}
			}
			$currencyLists = array_unique($currencyLists);
			$symbol = implode(',', $currencyLists);

			$url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=$symbol";
//			$url = "https://sandbox-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=$symbol";

			$headers = [
				'Accepts: application/json',
				'X-CMC_PRO_API_KEY:' . $coin_market_cap_app_key
			];
			$allCryptoConvert = BasicCurl::curlGetRequestWithHeaders($url, $headers);
			$allCryptoConvert = json_decode($allCryptoConvert, true);

			if (@$allCryptoConvert['data'] == '') {
				return 'error';
			}
			$coins = $allCryptoConvert['data'];

			foreach ($updateForMethods as $method) {
				$addField = [];
				foreach ($coins as $coin) {
					$symbol = $coin['symbol'];
					$curRate = $usdToBase / $coin['quote']['USD']['price'];

					foreach ($method->supported_currency as $key => $currency) {
						if ($key == 'USD') {
							$addField['USD'] = round(1 / $usdToBase, 2);
						}
						if ($symbol == $key) {
							$addField[$key] = $curRate;
							break;
						}
					}
				}
				$method->convert_rate = $addField;
				$method->save();
			}
		}
		return 0;
	}
}
