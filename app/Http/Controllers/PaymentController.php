<?php

namespace App\Http\Controllers;

use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\ManagePlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Facades\App\Services\BasicService;

class PaymentController extends Controller
{
    use Notify, Upload;

    public function addFundRequest(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'gateway' => 'required',
            'amount' => 'required'
        ]);
        if ($validator->fails()) {
            return response($validator->messages(), 422);
        }

        $basic = (object)config('basic');
        $gate = Gateway::where('code', $request->gateway)->where('status', 1)->first();
        if (!$gate) {
            return response()->json(['error' => 'Invalid Gateway'], 422);
        }


        $reqAmount = $request->amount;
        if ($gate->min_amount > $reqAmount || $gate->max_amount < $reqAmount) {
            return response()->json(['error' => 'Please Follow Transaction Limit'], 422);
        }


        $charge = getAmount($gate->fixed_charge + ($reqAmount * $gate->percentage_charge / 100));
        $payable = getAmount($reqAmount + $charge);
        $final_amo = getAmount($payable * $gate->convention_rate);
        $user = auth()->user();

        $fund = $this->newFund($request, $user, $gate, $charge, $final_amo, $reqAmount);

        session()->put('track', $fund['transaction']);


        if (1000 > $fund->gateway->id) {
            $method_currency = (checkTo($fund->gateway->currencies, $fund->gateway_currency) == 1) ? 'USD' : $fund->gateway_currency;
            $isCrypto = (checkTo($fund->gateway->currencies, $fund->gateway_currency) == 1) ? true : false;
        } else {
            $method_currency = $fund->gateway_currency;
            $isCrypto = false;
        }


        return [
            'gateway_image' => getFile(config('location.gateway.path') . $gate->image),
            'amount' => getAmount($fund->amount) . ' ' . $basic->currency_symbol,
            'charge' => getAmount($fund->charge) . ' ' . $basic->currency_symbol,
            'gateway_currency' => trans($fund->gateway_currency),
            'payable' => getAmount($fund->amount + $fund->charge) . ' ' . $basic->currency_symbol,
            'conversion_rate' => 1 . ' ' . $basic->currency . ' = ' . getAmount($fund->rate) . ' ' . $method_currency,
            'in' => trans('In') . ' ' . $method_currency . ':' . getAmount($fund->final_amount, 2),
            'isCrypto' => $isCrypto,
            'conversion_with' => ($isCrypto) ? trans('Conversion with') . $fund->gateway_currency . ' ' . trans('and final value will Show on next step') : null,
            'payment_url' => route('user.addFund.confirm'),
        ];

    }

    public function depositConfirm(Request $request)
    {
        $track = session()->get('track');
        $order = Fund::where('transaction', $track)->orderBy('id', 'DESC')->with(['gateway', 'user'])->first();
        if (is_null($order)) {
            return redirect()->route('user.addFund')->with('error', 'Invalid Fund Request');
        }
        if ($order->status != 0) {
            return redirect()->route('user.addFund')->with('error', 'Invalid Fund Request');
        }
        if (999 < $order->gateway->id) {
            return view(template() . 'user.payment.manual', compact('order'));
        }

        $method = $order->gateway->code;
        try {

            $getwayObj = 'App\\Services\\Gateway\\' . $method . '\\Payment';
            $data = $getwayObj::prepareData($order, $order->gateway);
            $data = json_decode($data);

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
        if (isset($data->error)) {
            return back()->with('error', $data->message);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }
        $page_title = 'Payment Confirm';
        return view(template() . $data->view, compact('data', 'page_title', 'order'));
    }

    public function fromSubmit(Request $request)
    {

        $basic = (object)config('basic');

        $track = session()->get('track');
        $data = Fund::where('transaction', $track)->orderBy('id', 'DESC')->with(['gateway', 'user'])->first();
        if (is_null($data)) {
            return redirect()->route('user.addFund')->with('error', 'Invalid Fund Request');
        }
        if ($data->status != 0) {
            return redirect()->route('user.addFund')->with('error', 'Invalid Fund Request');
        }
        $gateway = $data->gateway;
        $params = optional($data->gateway)->parameters;


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

        $this->validate($request, $rules);


        $path = config('location.deposit.path') . date('Y') . '/' . date('m') . '/' . date('d');
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
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }


        $data->created_at = Carbon::now();
        $data->status = 2; // pending
        $data->update();


        $msg = [
            'username' => $data->user->username,
            'amount' => getAmount($data->amount),
            'currency' => $basic->currency,
            'gateway' => $gateway->name
        ];
        $action = [
            "link" => route('admin.user.fundLog', $data->user_id),
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        $this->adminPushNotification('PAYMENT_REQUEST', $msg, $action);

        session()->flash('success', 'You request has been taken.');
        return redirect()->route('user.fund-history');
    }

    public function gatewayIpn(Request $request, $code, $trx = null, $type = null)
    {
        if (isset($request->m_orderid)) {
            $trx = $request->m_orderid;
        }
        if (isset($request->MERCHANT_ORDER_ID)) {
            $trx = $request->MERCHANT_ORDER_ID;
        }
        if (isset($request->payment_ref)) {
            $payment_ref = $request->payment_ref;
        }
        if ($code == 'coinbasecommerce') {
            $input = fopen("php://input", "r");
            @file_put_contents(time() . '_coinbasecommerce.txt', $input);

            $gateway = Gateway::where('code', $code)->first();

            $postdata = file_get_contents("php://input");
            $res = json_decode($postdata);

            if (isset($res->event)) {
                $order = Fund::where('transaction', $res->event->data->metadata->trx)->orderBy('id', 'DESC')->with(['gateway', 'user'])->first();
                //$headers = apache_request_headers();
                //$sentSign = $headers['X-Cc-Webhook-Signature'];
                $sentSign = $request->header('X-Cc-Webhook-Signature');

                $sig = hash_hmac('sha256', $postdata, $gateway->parameters->secret);
                @file_put_contents(time() . '_coinbasecommerce_sign.txt', $sentSign);

                if ($sentSign == $sig) {
                    if ($res->event->type == 'charge:confirmed' && $order->status == 0) {
                        BasicService::preparePaymentUpgradation($order);
                    }
                }
            }

            session()->flash('success', 'You request has been processing.');
            return redirect()->route('user.fund-history');
        }

        try {
            $gateway = Gateway::where('code', $code)->first();
            if (!$gateway) throw new \Exception('Invalid Payment Gateway.');
            if (isset($trx)) {
                $order = Fund::where('transaction', $trx)->orderBy('id', 'desc')->with(['gateway', 'user'])->first();
                if (!$order) throw new \Exception('Invalid Payment Request.');
            }
            if (isset($payment_ref)) {
                $order = Fund::where('btc_wallet', $payment_ref)->orderBy('id', 'desc')->with(['gateway', 'user'])->first();
                if (!$order) throw new \Exception('Invalid Payment Request.');
            }
            $getwayObj = 'App\\Services\\Gateway\\' . $code . '\\Payment';
            $data = $getwayObj::ipn($request, $gateway, @$order, @$trx, @$type);
            if (isset($data['redirect'])) {
                return redirect($data['redirect'])->with($data['status'], $data['msg']);
            }
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

    }

    public function success()
    {
        return view('success');
    }

    public function failed()
    {
        if (isset($request->status) && $request->status == 'DECLINED') {
            session()->flash('error', $request->message);
            return redirect()->route('failed');
        }
        return view('failed');
    }

    /**
     * @param Request $request
     * @param $user
     * @param $gate
     * @param $charge
     * @param $final_amo
     * @return Fund
     * @return $amount
     */
    public function newFund(Request $request, $user, $gate, $charge, $final_amo, $amount): Fund
    {
        $fund = new Fund();
        $fund->user_id = $user->id;
        $fund->gateway_id = $gate->id;
        $fund->gateway_currency = strtoupper($gate->currency);
        $fund->amount = $amount;
        $fund->charge = $charge;
        $fund->rate = $gate->convention_rate;
        $fund->final_amount = getAmount($final_amo);
        $fund->btc_amount = 0;
        $fund->btc_wallet = "";
        $fund->transaction = strRandom();
        $fund->try = 0;
        $fund->status = 0;
        $fund->save();
        return $fund;
    }
}
