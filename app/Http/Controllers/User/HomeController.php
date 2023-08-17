<?php

namespace App\Http\Controllers\User;

use App\Helper\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\BetInvest;
use App\Models\BetInvestLog;
use App\Models\Fund;
use App\Models\GameOption;
use App\Models\Gateway;
use App\Models\IdentifyForm;
use App\Models\KYC;
use App\Models\Language;
use App\Models\PayoutLog;
use App\Models\PayoutMethod;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;

use hisorange\BrowserDetect\Parser as Browser;

class HomeController extends Controller
{
    use Upload, Notify;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['betInvests'] = BetInvest::with('betInvestLog')->where('user_id', $this->user->id)->orderBy('id', 'desc')->limit(6)->get();
        $data['userBet'] = collect(BetInvest::with('betInvestLog')->where('user_id', $this->user->id)
            ->selectRaw('SUM(CASE WHEN status != 2 THEN invest_amount END) as totalInvest')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN return_amount END) as totalReturn')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS win')
            ->selectRaw('COUNT(CASE WHEN status != 2 THEN id END) AS totalBet')
            ->orderBy('id', 'desc')
            ->get()->toArray())->collapse();

        $dailyPayout = $this->dayList();

        BetInvest::where('user_id', $this->user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->select(
                DB::raw('SUM(invest_amount) as totalInvest'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyPayout) {
                $dailyPayout->put($item['date'], round($item['totalInvest'], 2));
            });

        $data['dailyPayout'] = $dailyPayout;
        return view($this->theme . 'user.dashboard', $data);
    }


    public function dayList()
    {
        $totalDays = $this->days_in_month(date('m'), date('Y'));
        $daysByMonth = [];
        for ($i = 1; $i <= $totalDays; $i++) {
            array_push($daysByMonth, ['Day ' . sprintf("%02d", $i) => 0]);
        }
        return collect($daysByMonth)->collapse();
    }

    public function days_in_month($month, $year)
    {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public function transaction()
    {
        $transactions = $this->user->transaction()->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.index', compact('transactions'));
    }

    public function transactionSearch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $transaction = Transaction::where('user_id', $this->user->id)->with('user')
            ->when(@$search['transaction_id'], function ($query) use ($search) {
                return $query->where('trx_id', 'LIKE', "%{$search['transaction_id']}%");
            })
            ->when(@$search['remark'], function ($query) use ($search) {
                return $query->where('remarks', 'LIKE', "%{$search['remark']}%");
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));
        $transactions = $transaction->appends($search);


        return view($this->theme . 'user.transaction.index', compact('transactions'));

    }

    public function fundHistory()
    {
        $funds = Fund::where('user_id', $this->user->id)->where('status', '!=', 0)->orderBy('id', 'DESC')->with('gateway')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));
    }

    public function fundHistorySearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $funds = Fund::orderBy('id', 'DESC')->where('user_id', $this->user->id)->where('status', '!=', 0)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('transaction', 'LIKE', $search['name']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->with('gateway')
            ->paginate(config('basic.paginate'));
        $funds->appends($search);

        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));

    }


    public function addFund()
    {
        if (session()->get('plan_id') != null) {
            return redirect(route('user.payment'));
        }

        $data['totalPayment'] = null;
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();

        return view($this->theme . 'user.addFund', $data);
    }


    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        $data['user'] = $this->user;
        $data['languages'] = Language::all();
        $data['identityFormList'] = IdentifyForm::where('status', 1)->get();
        if ($request->has('identity_type')) {
            $validator->errors()->add('identity', '1');
            $data['identity_type'] = $request->identity_type;
            $data['identityForm'] = IdentifyForm::where('slug', trim($request->identity_type))->where('status', 1)->firstOrFail();
            return view($this->theme . 'user.profile.myprofile', $data)->withErrors($validator);
        }

        return view($this->theme . 'user.profile.myprofile', $data);
    }


    public function updateProfile(Request $request)
    {
        $allowedExtensions = array('jpg', 'png', 'jpeg');

        $image = $request->image;
        $this->validate($request, [
            'image' => [
                'required',
                'max:4096',
                function ($fail) use ($image, $allowedExtensions) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (($image->getSize() / 1000000) > 2) {
                        return $fail("Images MAX  2MB ALLOW!");
                    }
                    if (!in_array($ext, $allowedExtensions)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                }
            ]
        ]);
        $user = $this->user;
        if ($request->hasFile('image')) {
            $path = config('location.user.path');
            try {
                $user->image = $this->uploadImage($image, $path);
            } catch (\Exception $exp) {
                return back()->with('error', 'Could not upload your ' . $image)->withInput();
            }
        }
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }


    public function updateInformation(Request $request)
    {

        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $req = Purify::clean($request->all());
        $user = $this->user;
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => "sometimes|required|alpha_dash|min:5|unique:users,username," . $user->id,
            'address' => 'required',
            'language_id' => Rule::in($languages),
        ];
        $message = [
            'firstname.required' => 'First Name field is required',
            'lastname.required' => 'Last Name field is required',
        ];

        $validator = Validator::make($req, $rules, $message);
        if ($validator->fails()) {
            $validator->errors()->add('profile', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user->language_id = $req['language_id'];
        $user->firstname = $req['firstname'];
        $user->lastname = $req['lastname'];
        $user->username = $req['username'];
        $user->address = $req['address'];
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }


    public function updatePassword(Request $request)
    {

        $rules = [
            'current_password' => "required",
            'password' => "required|min:5|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('password', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user = $this->user;
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return back()->with('success', 'Password Changes successfully.');
            } else {
                throw new \Exception('Current password did not match');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function twoStepSecurity()
    {
        $basic = (object)config('basic');
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $secret);
        $previousCode = $this->user->two_fa_code;

        $previousQR = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $previousCode);
        return view($this->theme . 'user.twoFA.index', compact('secret', 'qrCodeUrl', 'previousCode', 'previousQR'));
    }

    public function twoStepEnable(Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        $userCode = $request->code;
        if ($oneCode == $userCode) {
            $user['two_fa'] = 1;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = $request->key;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_ENABLED', [
                'action' => 'Enabled',
                'code' => $user->two_fa_code,
                'ip' => request()->ip(),
                'browser' => $browser->browserName() . ', ' . $browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);
            return back()->with('success', 'Google Authenticator Has Been Enabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }


    }


    public function twoStepDisable(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        $user = $this->user;
        $ga = new GoogleAuthenticator();

        $secret = $user->two_fa_code;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['two_fa'] = 0;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = null;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_DISABLED', [
                'action' => 'Disabled',
                'ip' => request()->ip(),
                'browser' => $browser->browserName() . ', ' . $browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);

            return back()->with('success', 'Google Authenticator Has Been Disabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }
    }


    /*
     * User payout Operation
     */
    public function payoutMoney()
    {
        $data['title'] = "Payout Money";
        $data['gateways'] = PayoutMethod::whereStatus(1)->get();
        return view($this->theme . 'user.payout.money', $data);
    }

    public function payoutMoneyRequest(Request $request)
    {
        $this->validate($request, [
            'gateway' => 'required|integer',
            'amount' => ['required', 'numeric']
        ]);


        $basic = (object)config('basic');
        $method = PayoutMethod::where('id', $request->gateway)->where('status', 1)->firstOrFail();
        $authWallet = $this->user;

        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);

        $finalAmo = $request->amount + $charge;

        if ($request->amount < $method->minimum_amount) {
            session()->flash('error', 'Minimum payout Amount ' . round($method->minimum_amount, 2) . ' ' . $basic->currency);
            return back();
        }
        if ($request->amount > $method->maximum_amount) {
            session()->flash('error', 'Maximum payout Amount ' . round($method->maximum_amount, 2) . ' ' . $basic->currency);
            return back();
        }

        if (getAmount($finalAmo) > $authWallet['balance']) {
            session()->flash('error', 'Insufficient ' . snake2Title($authWallet['balance']) . ' For Withdraw.');
            return back();
        } else {
            $trx = strRandom();
            $withdraw = new PayoutLog();
            $withdraw->user_id = $authWallet->id;
            $withdraw->method_id = $method->id;
            $withdraw->amount = getAmount($request->amount);
            $withdraw->charge = $charge;
            $withdraw->net_amount = $finalAmo;
            $withdraw->trx_id = $trx;
            $withdraw->status = 0;
            $withdraw->save();
            session()->put('wtrx', $trx);
            return redirect()->route('user.payout.preview');
        }
    }


    public function payoutPreview()
    {
        $withdraw = PayoutLog::latest()->where('trx_id', session()->get('wtrx'))->where('status', 0)->latest()->with('method', 'user')->firstOrFail();
        $payoutMethod = $withdraw->method;
        $title = "Withdraw Form";

        $layout = 'layouts.user';
        $remaining = getAmount(auth()->user()->balance - $withdraw->net_amount);

        if ($payoutMethod->code == 'flutterwave') {
            return view($this->theme . 'user.payout.gateway.' . $payoutMethod->code, compact('withdraw', 'title', 'remaining', 'layout', 'payoutMethod'));
        } elseif ($payoutMethod->code == 'paystack') {
            return view($this->theme . 'user.payout.gateway.' . $payoutMethod->code, compact('withdraw', 'title', 'remaining', 'layout', 'payoutMethod'));
        }
        return view($this->theme . 'user.payout.preview', compact('withdraw', 'title', 'remaining', 'layout', 'payoutMethod'));
    }

    public function getBankList(Request $request)
    {
        $currencyCode = $request->currencyCode;
        $methodObj = 'App\\Services\\Payout\\paystack\\Card';
        $data = $methodObj::getBank($currencyCode);
        return $data;
    }

    public function getBankForm(Request $request)
    {
        $bankName = $request->bankName;
        $bankArr = config('banks.' . $bankName);

        if ($bankArr['api'] != null) {

            $methodObj = 'App\\Services\\Payout\\flutterwave\\Card';
            $data = $methodObj::getBank($bankArr['api']);
            $value['bank'] = $data;
        }
        $value['input_form'] = $bankArr['input_form'];
        return $value;
    }

    public function paystackPayout(Request $request, $trx_id)
    {
        $payout = PayoutLog::where('trx_id', $trx_id)->firstOrFail();
        $payoutMethod = PayoutMethod::find($payout->method_id);
        $user = $this->user;

        $purifiedData = Purify::clean($request->all());

        if (empty($purifiedData['bank'])) {
            return back()->with('alert', 'Bank field is required')->withInput();
        }

        $rules = [];
        $inputField = [];
        if ($payoutMethod->input_form != null) {
            foreach ($payoutMethod->input_form as $key => $cus) {

                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $rules['type'] = 'required';
        $rules['currency'] = 'required';

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        if (getAmount($payout->net_amount) > $user->balance) {
            session()->flash('error', 'Insufficient balance For Payout.');
            return redirect()->route('user.payout.money');
        }

        $collection = collect($purifiedData);
        $reqField = [];
        if ($payoutMethod->input_form != null) {
            foreach ($collection as $k => $v) {
                foreach ($payoutMethod->input_form as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->file($inKey) && $request->file($inKey)->isValid()) {
                                $extension = $request->$inKey->extension();
                                $fileName = strtolower(strtotime("now") . '.' . $extension);
                                $storedPath = config('location.withdrawLog.path');
                                $imageMake = Image::make($purifiedData[$inKey]);
                                $imageMake->save($storedPath);

                                $reqField[$inKey] = [
                                    'fieldValue' => $fileName,
                                    'type' => $inVal->type,
                                ];
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'fieldValue' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $reqField['type'] = [
                'fieldValue' => $request->type,
                'type' => 'text',
            ];
            $reqField['bank_code'] = [
                'fieldValue' => $request->bank,
                'type' => 'text',
            ];
            $reqField['amount'] = [
                'fieldValue' => $payout->amount * convertRate($request->currency, $payout),
                'type' => 'text',
            ];
            $payout->information = $reqField;
        } else {
            $payout->information = null;
        }
        $payout->currency_code = $request->currency_code;
        $payout->status = 1;
        $payout->save();

        $user->balance = $user->balance - $payout->net_amount;
        $user->save();

        $remarks = 'Withdraw Via ' . optional($payout->method)->name;
        BasicService::makeTransaction($user, $payout->amount, $payout->charge, '-', $payout->trx_id, $remarks);

        $this->userNotify($user, $payout);

        return redirect(route('user.payout.money'))->with('success', 'Withdraw request Successfully Submitted. Wait For Confirmation.');
    }


    public function flutterwavePayout(Request $request, $trx_id)
    {
        $payout = PayoutLog::where('trx_id', $trx_id)->first();
        $payoutMethod = PayoutMethod::find($payout->method_id);
        $user = $this->user;

        $purifiedData = Purify::clean($request->all());

        if (empty($purifiedData['transfer_name'])) {
            return back()->with('alert', 'Transfer field is required');
        }
        $validation = config('banks.' . $purifiedData['transfer_name'] . '.validation');

        $rules = [];
        $inputField = [];
        if ($validation != null) {
            foreach ($validation as $key => $cus) {
                $rules[$key] = 'required';
                $inputField[] = $key;
            }
        }

        if (getAmount($payout->net_amount) > $user->balance) {
            session()->flash('error', 'Insufficient balance For Withdraw.');
            return redirect()->route('user.payout.money');
        }

        if ($request->transfer_name == 'NGN BANK' || $request->transfer_name == 'NGN DOM' || $request->transfer_name == 'GHS BANK'
            || $request->transfer_name == 'KES BANK' || $request->transfer_name == 'ZAR BANK' || $request->transfer_name == 'ZAR BANK') {
            $rules['bank'] = 'required';
        }

        $rules['currency_code'] = 'required';

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        $collection = collect($purifiedData);
        $reqField = [];
        $metaField = [];

        if (config('banks.' . $purifiedData['transfer_name'] . '.input_form') != null) {
            foreach ($collection as $k => $v) {
                foreach (config('banks.' . $purifiedData['transfer_name'] . '.input_form') as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {

                        if ($inVal == 'meta') {
                            $metaField[$inKey] = $v;
                            $metaField[$inKey] = [
                                'fieldValue' => $v,
                                'type' => 'text',
                            ];
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'fieldValue' => $v,
                                'type' => 'text',
                            ];
                        }
                    }
                }
            }

            if ($request->transfer_name == 'NGN BANK' || $request->transfer_name == 'NGN DOM' || $request->transfer_name == 'GHS BANK'
                || $request->transfer_name == 'KES BANK' || $request->transfer_name == 'ZAR BANK' || $request->transfer_name == 'ZAR BANK') {

                $reqField['account_bank'] = [
                    'fieldValue' => $request->bank,
                    'type' => 'text',
                ];
            } elseif ($request->transfer_name == 'XAF/XOF MOMO') {
                $reqField['account_bank'] = [
                    'fieldValue' => 'MTN',
                    'type' => 'text',
                ];
            } elseif ($request->transfer_name == 'FRANCOPGONE' || $request->transfer_name == 'mPesa' || $request->transfer_name == 'Rwanda Momo'
                || $request->transfer_name == 'Uganda Momo' || $request->transfer_name == 'Zambia Momo') {
                $reqField['account_bank'] = [
                    'fieldValue' => 'MPS',
                    'type' => 'text',
                ];
            }

            if ($request->transfer_name == 'Barter') {
                $reqField['account_bank'] = [
                    'fieldValue' => 'barter',
                    'type' => 'text',
                ];
            } elseif ($request->transfer_name == 'flutterwave') {
                $reqField['account_bank'] = [
                    'fieldValue' => 'barter',
                    'type' => 'text',
                ];
            }


            $reqField['amount'] = [
                'fieldValue' => $payout->amount * convertRate($request->currency_code, $payout),
                'type' => 'text',
            ];

            $payout->information = $reqField;
            $payout->meta_field = $metaField;
        } else {
            $payout->information = null;
            $payout->meta_field = null;
        }

        $payout->status = 1;
        $payout->currency_code = $request->currency_code;
        $payout->save();

        $user->balance = $user->balance - $payout->net_amount;
        $user->save();

        $remarks = 'Withdraw Via ' . optional($payout->method)->name;
        BasicService::makeTransaction($user, $payout->amount, $payout->charge, '-', $payout->trx_id, $remarks);

        $this->userNotify($user, $payout);

        return redirect(route('user.payout.money'))->with('success', 'Payout request Successfully Submitted. Wait For Confirmation.');
    }


    public function payoutRequestSubmit(Request $request)
    {
        $basic = (object)config('basic');
        $withdraw = PayoutLog::latest()->where('trx_id', session()->get('wtrx'))->where('status', 0)->with('method', 'user')->firstOrFail();
        $rules = [];
        $inputField = [];
        if (optional($withdraw->method)->input_form != null) {
            foreach (optional($withdraw->method)->input_form as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        if (optional($withdraw->method)->is_automatic == 1) {
            $rules['currency_code'] = 'required';
            if (optional($withdraw->method)->code == 'paypal') {
                $rules['recipient_type'] = 'required';
            }
        }

        $this->validate($request, $rules);

        $user = $this->user;

        if (getAmount($withdraw->net_amount) > $user->balance) {
            session()->flash('error', 'Insufficient balance For Payout.');
            return redirect()->route('user.payout.money');
        } else {
            $collection = collect($request);
            $reqField = [];
            if (optional($withdraw->method)->input_form != null) {
                foreach ($collection as $k => $v) {
                    foreach ($withdraw->method->input_form as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            if ($inVal->type == 'file') {
                                if ($request->hasFile($inKey)) {
                                    $image = $request->file($inKey);
                                    $filename = time() . uniqid() . '.jpg';
                                    $location = config('location.withdrawLog.path');
                                    $reqField[$inKey] = [
                                        'fieldValue' => $filename,
                                        'type' => $inVal->type,
                                    ];
                                    try {
                                        $this->uploadImage($image, $location, $size = null, $old = null, $thumb = null, $filename);
                                    } catch (\Exception $exp) {
                                        return back()->with('error', 'Image could not be uploaded.');
                                    }

                                }
                            } else {
                                $reqField[$inKey] = $v;
                                $reqField[$inKey] = [
                                    'fieldValue' => $v,
                                    'type' => $inVal->type,
                                ];
                            }
                        }
                    }
                }
                if (optional($withdraw->method)->is_automatic == 1) {
                    $reqField['amount'] = [
                        'fieldValue' => $withdraw->amount * convertRate($request->currency_code, $withdraw),
                        'type' => 'text',
                    ];
                }
                if (optional($withdraw->method)->code == 'paypal') {
                    $reqField['recipient_type'] = [
                        'fieldValue' => $request->recipient_type,
                        'type' => 'text',
                    ];
                }
                $withdraw['information'] = $reqField;
            } else {
                $withdraw['information'] = null;
            }

            $withdraw->currency_code = @$request->currency_code;
            $withdraw->status = 1;
            $withdraw->save();

            $user['balance'] -= $withdraw->net_amount;
            $user->save();


            $remarks = 'Withdraw Via ' . optional($withdraw->method)->name;
            BasicService::makeTransaction($user, $withdraw->amount, $withdraw->charge, '-', $withdraw->trx_id, $remarks);

            $this->userNotify($user, $withdraw);

            session()->flash('success', 'Payout request Successfully Submitted. Wait For Confirmation.');

            return redirect()->route('user.payout.money');
        }
    }

    public function userNotify($user, $withdraw)
    {
        $basic = (object)config('basic');

        $this->sendMailSms($user, $type = 'PAYOUT_REQUEST', [
            'method_name' => optional($withdraw->method)->name,
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $basic->currency,
            'trx' => $withdraw->trx_id,
        ]);


        $msg = [
            'username' => $user->username,
            'amount' => getAmount($withdraw->amount),
            'currency' => $basic->currency,
        ];

        $action = [
            "link" => route('admin.user.withdrawal', $user->id),
            "icon" => "fa fa-money-bill-alt "
        ];

        $this->adminPushNotification('PAYOUT_REQUEST', $msg, $action);
    }

    public function payoutHistory()
    {
        $user = $this->user;
        $data['payoutLog'] = PayoutLog::whereUser_id($user->id)->where('status', '!=', 0)->latest()->with('user', 'method')->paginate(config('basic.paginate'));
        $data['title'] = "Payout Log";
        return view($this->theme . 'user.payout.log', $data);
    }


    public function payoutHistorySearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $payoutLog = PayoutLog::orderBy('id', 'DESC')->where('user_id', $this->user->id)->where('status', '!=', 0)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('trx_id', 'LIKE', $search['name']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->with('user', 'method')->paginate(config('basic.paginate'));
        $payoutLog->appends($search);

        $title = "Payout Log";
        return view($this->theme . 'user.payout.log', compact('title', 'payoutLog'));
    }


    public function verificationSubmit(Request $request)
    {
        $identityFormList = IdentifyForm::where('status', 1)->get();
        $rules['identity_type'] = ["required", Rule::in($identityFormList->pluck('slug')->toArray())];
        $identity_type = $request->identity_type;
        $identityForm = IdentifyForm::where('slug', trim($identity_type))->where('status', 1)->firstOrFail();

        $params = $identityForm->services_form;

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('identity', '1');

            return back()->withErrors($validator)->withInput();
        }


        $path = config('location.kyc.path') . date('Y') . '/' . date('m') . '/' . date('d');
        $collection = collect($request);

        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $this->uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    session()->flash('error', 'Could not upload your ' . $inKey);
                                    return back()->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
        }

        try {

            DB::beginTransaction();

            $user = $this->user;
            $kyc = new KYC();
            $kyc->user_id = $user->id;
            $kyc->kyc_type = $identityForm->slug;
            $kyc->details = $reqField;
            $kyc->save();

            $user->identity_verify = 1;
            $user->save();

            if (!$kyc) {
                DB::rollBack();
                $validator->errors()->add('identity', '1');
                return back()->withErrors($validator)->withInput()->with('error', "Failed to submit request");
            }
            DB::commit();
            return redirect()->route('user.profile')->withErrors($validator)->with('success', 'KYC request has been submitted.');

        } catch (\Exception $e) {
            return redirect()->route('user.profile')->withErrors($validator)->with('error', $e->getMessage());
        }
    }

    public function addressVerification(Request $request)
    {

        $rules = [];
        $rules['addressProof'] = ['image', 'mimes:jpeg,jpg,png', 'max:2048'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('addressVerification', '1');
            return back()->withErrors($validator)->withInput();
        }

        $path = config('location.kyc.path') . date('Y') . '/' . date('m') . '/' . date('d');

        $reqField = [];
        try {
            if ($request->hasFile('addressProof')) {
                $reqField['addressProof'] = [
                    'field_name' => $this->uploadImage($request['addressProof'], $path),
                    'type' => 'file',
                ];
            } else {
                $validator->errors()->add('addressVerification', '1');

                session()->flash('error', 'Please select a ' . 'address Proof');
                return back()->withInput();
            }
        } catch (\Exception $exp) {
            session()->flash('error', 'Could not upload your ' . 'address Proof');
            return redirect()->route('user.profile')->withInput();
        }

        try {

            DB::beginTransaction();
            $user = $this->user;
            $kyc = new KYC();
            $kyc->user_id = $user->id;
            $kyc->kyc_type = 'address-verification';
            $kyc->details = $reqField;
            $kyc->save();
            $user->address_verify = 1;
            $user->save();

            if (!$kyc) {
                DB::rollBack();
                $validator->errors()->add('addressVerification', '1');
                return redirect()->route('user.profile')->withErrors($validator)->withInput()->with('error', "Failed to submit request");
            }
            DB::commit();
            return redirect()->route('user.profile')->withErrors($validator)->with('success', 'Your request has been submitted.');

        } catch (\Exception $e) {
            $validator->errors()->add('addressVerification', '1');
            return redirect()->route('user.profile')->with('error', $e->getMessage())->withErrors($validator);
        }
    }

    public function referral()
    {
        $title = "Invite Friends";
        $referrals = getLevelUser($this->user->id);
        return view($this->theme . 'user.referral', compact('title', 'referrals'));
    }

    public function referralBonus()
    {
        $title = "Referral Bonus";
        $transactions = $this->user->referralBonusLog()->latest()->with('bonusBy:id,firstname,lastname')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.referral-bonus', compact('title', 'transactions'));
    }

    public function referralBonusSearch(Request $request)
    {
        $title = "Referral Bonus";
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $transaction = $this->user->referralBonusLog()->latest()
            ->with('bonusBy:id,firstname,lastname')
            ->when(isset($search['search_user']), function ($query) use ($search) {
                return $query->whereHas('bonusBy', function ($q) use ($search) {
                    $q->where(DB::raw('concat(firstname, " ", lastname)'), 'LIKE', "%{$search['search_user']}%")
                        ->orWhere('firstname', 'LIKE', '%' . $search['search_user'] . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $search['search_user'] . '%')
                        ->orWhere('username', 'LIKE', '%' . $search['search_user'] . '%');
                });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));
        $transactions = $transaction->appends($search);

        return view($this->theme . 'user.transaction.referral-bonus', compact('title', 'transactions'));
    }


    public function betSlip(Request $request)
    {
        $basic = (object)config('basic');

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'activeSlip' => 'required',
            'activeSlip.*' => 'required',
        ], [
            'amount.required' => "Amount Field is required",
            'activeSlip.required' => "Please make prediction slip or list",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }
        $user = $this->user;


        $idCollection = collect($request->activeSlip)->pluck('id');

        $requestAmount = $request->amount;
        if ($user->balance < $requestAmount) {
            return response()->json(['errors' => ['amount' => ['Insufficient Balance']]]);
        }
        if ($basic->minimum_bet > $requestAmount) {
            return response()->json(['errors' => ['amount' => ["Minimum  Amount $basic->minimum_bet $basic->currency_symbol need!"]]]);
        }


        $predictionList = GameOption::query();

        $predictionActiveList = $predictionList->where('status', 1)
            ->whereHas('gameMatch', function ($q) {
                $q->where('status', 1)->where('is_unlock', 0);
            })
            ->whereHas('gameQuestion', function ($q) {
                $q->where('status', 1)->where('end_time', '>', Carbon::now())
                    ->where('is_unlock', 0);
            })
            ->orderBy('id', 'desc')
            ->whereIn('id', $idCollection)
            ->with([
                'gameMatch:id,name,team1_id,team2_id,tournament_id,category_id,is_unlock,status',
                'gameMatch.gameCategory:id,name,icon',
                'gameMatch.gameTeam1:id,name',
                'gameMatch.gameTeam2:id,name',
                'gameMatch.gameTournament:id,name',
                'gameQuestion:id,name,status,end_time,result,is_unlock'
            ])
            ->get();


        $getRatio = 1;
        $newSlip = $predictionActiveList->map(function ($item) use (&$getRatio) {
            $getRatio *= $item->ratio;
            return [
                "id" => $item->id,
                'status' => $item->status,
                "category_icon" => optional(optional($item->gameMatch)->gameCategory)->icon,
                "category_name" => optional(optional($item->gameMatch)->gameCategory)->name,
                "is_unlock_match" => optional($item->gameMatch)->is_unlock,
                "is_unlock_question" => optional($item->gameQuestion)->is_unlock,
                "match_id" => $item->match_id,
                "match_name" => optional(optional($item->gameMatch)->gameTeam1)->name . ' vs ' . optional(optional($item->gameMatch)->gameTeam2)->name,
                "option_name" => $item->option_name,
                "question_id" => $item->question_id,
                "question_name" => optional($item->gameQuestion)->name,
                "ratio" => (float)$item->ratio,
                "tournament_name" => optional(optional($item->gameMatch)->gameTournament)->name,
            ];
        });

        if (collect($request->activeSlip)->count() != count($predictionActiveList)) {
            return response()->json([
                'newSlip' => $newSlip,
                'newSlipMessage' => 'Please remove expired marking point',
            ]);
        }

        DB::beginTransaction();

        $user->balance -= round($requestAmount, 2);
        $user->save();


        $title = 'Bet in ' . count($newSlip) . ' Matches By Bet slip';
        $trx = strRandom();
        BasicService::makeTransaction($user, getAmount($requestAmount), getAmount(0), '-', $trx, $title);

        $finalRatioReturnAmo = round(($requestAmount * $getRatio), 2);

        $invest = new BetInvest();
        $invest->transaction_id = strRandom();
        $invest->user_id = $user->id;
        $invest->creator_id = null;
        $invest->invest_amount = $requestAmount;
        $invest->return_amount = $finalRatioReturnAmo;
        $invest->charge = 0;
        $invest->remaining_balance = $user->balance;
        $invest->ratio = round($getRatio, 3);
        $invest->status = 0;
        $invest->isMultiBet = (count($newSlip) == 1) ? 0 : 1;
        $invest->save();

        $newSlip->map(function ($item) use ($invest, $user) {
            $betInv = new BetInvestLog();
            $betInv->bet_invest_id = $invest->id;
            $betInv->user_id = $user->id;
            $betInv->match_id = $item['match_id'];
            $betInv->question_id = $item['question_id'];
            $betInv->bet_option_id = $item['id'];
            $betInv->ratio = $item['ratio'];
            $betInv->category_icon = $item['category_icon'];
            $betInv->category_name = $item['category_name'];
            $betInv->tournament_name = $item['tournament_name'];
            $betInv->match_name = $item['match_name'];
            $betInv->question_name = $item['question_name'];
            $betInv->option_name = $item['option_name'];
            $betInv->status = 0;
            $betInv->save();
        });


        if ($basic->bet_commission == 1) {
            BasicService::setBonus($user, getAmount($requestAmount), 'bet_invest');
        }

        DB::commit();
        return response()->json(['success' => true]);


    }

}
