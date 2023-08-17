<?php
return [

	'NGN BANK' => [
		"api" => "NG",
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'NGN DOM' => [
		"api" => "NG",
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
			"first_name" => "meta",
			"last_name" => "meta",
			"email" => "meta",
			"beneficiary_country" => "meta",
			"mobile_number" => "meta",
			"sender" => "meta",
			"merchant_name" => "meta",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'GHS BANK' => [
		"api" => "GH",
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'KES BANK' => [
		"api" => "KE",
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
			"sender" => "meta",
			"sender_country" => "meta",
			"mobile_number" => "meta",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'ZAR BANK' => [
		"api" => "ZA",
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
			"first_name" => "meta",
			"last_name" => "meta",
			"email" => "meta",
			"mobile_number" => "meta",
			"recipient_address" => "meta",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'INTL EUR & GBP' => [
		"api" => null,
		'input_form' => [
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
			"AccountNumber" => "meta",
			"RoutingNumber" => "meta",
			"SwiftCode" => "meta",
			"BankName" => "meta",
			"BeneficiaryName" => "meta",
			"BeneficiaryCountry" => "meta",
			"PostalCode" => "meta",
			"StreetNumber" => "meta",
			"StreetName" => "meta",
			"City" => "meta",
		],
		'validation' => [
			"narration" => "required",
			"AccountNumber" => "required",
		],
	],

	'INTL USD' => [
		"api" => null,
		'input_form' => [
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
			"AccountNumber" => "meta",
			"RoutingNumber" => "meta",
			"SwiftCode" => "meta",
			"BankName" => "meta",
			"BeneficiaryName" => "meta",
			"BeneficiaryAddress" => "meta",
			"BeneficiaryCountry" => "meta",
		],
		'validation' => [
			"narration" => "required",
			"AccountNumber" => "required",
		],
	],

	'INTL OTHERS' => [
		"api" => null,
		'input_form' => [
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
			"AccountNumber" => "meta",
			"RoutingNumber" => "meta",
			"SwiftCode" => "meta",
			"BankName" => "meta",
			"BeneficiaryName" => "meta",
			"BeneficiaryAddress" => "meta",
			"BeneficiaryCountry" => "meta",
		],
		'validation' => [
			"narration" => "required",
			"AccountNumber" => "required",
		],
	],

	'FRANCOPGONE' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'XAF/XOF MOMO' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'mPesa' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
			"sender" => "meta",
			"sender_country" => "meta",
			"mobile_number" => "meta",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'Rwanda Momo' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'Uganda Momo' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'Zambia Momo' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
	],

	'Barter' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

	'FLW' => [
		"api" => null,
		'input_form' => [
			"account_number" => "",
			"narration" => "",
			"reference" => "",
			"beneficiary_name" => "",
		],
		'validation' => [
			"account_number" => "required",
			"narration" => "required",
		],
	],

];
