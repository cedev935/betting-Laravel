<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Models\PayoutLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PayoutRecordController extends Controller
{
    use Notify;

    public function index()
    {
        $page_title = "Payout Logs";
        $records = PayoutLog::where('status', '!=', 0)->orderBy('id', 'DESC')->with('user', 'method')->paginate(config('basic.paginate'));
        return view('admin.payout.logs', compact('records', 'page_title'));
    }


    public function request()
    {
        $page_title = "Payout Request";
        $records = PayoutLog::with(['user'])->where('status', 1)->orderBy('id', 'DESC')->with('user', 'method')->paginate(config('basic.paginate'));
        return view('admin.payout.logs', compact('records', 'page_title'));
    }

    public function search(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $records = PayoutLog::when(isset($search['name']), function ($query) use ($search) {
            return $query->where('trx_id', 'LIKE', $search['name'])
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search['name']}%")
                        ->orWhere('username', 'LIKE', "%{$search['name']}%");
                });

        })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->where('status', '!=', 0)
            ->with('user', 'method')
            ->paginate(config('basic.paginate'));
        $records->appends($search);

        $page_title = "Search Payout Logs";
        return view('admin.payout.logs', compact('records', 'page_title'));
    }

    public function view($id)
    {
        $data['payout'] = PayoutLog::findOrFail($id);
        return view('admin.payout.view', $data);
    }


    public function payoutCancel(Request $request, $id)
    {
        $basic = (object)config('basic');
        $data = PayoutLog::where('id', $id)->whereIn('status', [1])->with('user', 'method')->firstOrFail();

        $data->status = 3;
        $data->feedback = $request->feedback;
        $data->save();


        $user = $data->user;
        $user->balance += $data->net_amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($data->net_amount);
        $transaction->final_balance = $user->balance;
        $transaction->charge = $data->charge;
        $transaction->trx_type = '+';
        $transaction->remarks = getAmount($data->amount) . ' ' . $basic->currency . ' withdraw amount has been refunded';
        $transaction->trx_id = $data->trx_id;
        $transaction->save();


        try {
            $this->sendMailSms($user, $type = 'PAYOUT_REJECTED', [
                'method' => optional($data->method)->name,
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $basic->currency,
                'transaction' => $data->trx_id,
                'feedback' => $data->feedback
            ]);


            $msg = [
                'amount' => getAmount($data->amount),
                'currency' => $basic->currency,
            ];
            $action = [
                "link" => route('user.payout.history'),
                "icon" => "fa fa-money-bill-alt "
            ];
            $this->userPushNotification($user, 'PAYOUT_REJECTED', $msg, $action);
        } catch (\Exception $e) {

        }

        session()->flash('success', 'Reject Successfully');
        return back();
    }


    public function payoutConfirm(Request $request, $id)
    {
        $payout = PayoutLog::where('id', $id)->whereIn('status', [1])->with('user', 'method')->firstOrFail();
        $basic = (object)config('basic');

        $method = $payout->method;

        if ($method->is_automatic == 1) {
            $methodObj = 'App\\Services\\Payout\\' . $method->code . '\\Card';
            $data = $methodObj::payouts($payout);
            if (!$data) {
                return back()->with('error', 'Method not available or unknown errors occur');
            }

            if ($data['status'] == 'error') {
                $payout->last_error = $data['data'];
                $payout->save();
                return back()->with('error', $data['data']);
            }
        }

        $payout->status = 2;
        $payout->feedback = $request->feedback;
        $payout->save();

        $this->userSuccessNotify($payout);

        session()->flash('success', 'Approve Successfully');
        return back();
    }


    public function userSuccessNotify($data)
    {
        $user = $data->user;
        $basic = (object)config('basic');
        try {
            $this->sendMailSms($user, 'PAYOUT_APPROVE', [
                'method' => optional($data->method)->name,
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $basic->currency,
                'transaction' => $data->trx_id,
                'feedback' => $data->feedback
            ]);


            $msg = [
                'amount' => getAmount($data->amount),
                'currency' => $basic->currency,
            ];
            $action = [
                "link" => route('user.payout.history'),
                "icon" => "fa fa-money-bill-alt "
            ];

            $this->userPushNotification($user, 'PAYOUT_APPROVE', $msg, $action);
        } catch (\Exception $e) {

        }

        return 0;
    }


    public function payout($code, Request $request)
    {
        $apiResponse = json_decode($request->all());
        if ($code == 'razorpay') {
            $this->razorpayPayoutWebhook($apiResponse);
        }
        if ($code == 'flutterwave') {
            $this->razorpayPayoutWebhook($apiResponse);
        }
        if ($code == 'paystack') {
            $this->paystackPayoutWebhook($apiResponse);
        }
        if ($code == 'paypal') {
            $this->paypalPayoutWebhook($apiResponse);
        }
    }


    public function razorpayPayoutWebhook($apiResponse)
    {
        $basic = (object)config('basic');
        if ($apiResponse) {
            if ($apiResponse->payload) {
                if ($apiResponse->payload->payout) {
                    if ($apiResponse->payload->payout->entity) {
                        $payout = PayoutLog::where('response_id', $apiResponse->payload->payout->entity->id)->first();
                        $user = $payout->user;
                        if ($payout) {
                            if ($apiResponse->event == 'payout.processed' || $apiResponse->event == 'payout.updated') {
                                if ($payout->status != 2) {

                                    $payout->status = 2;
                                    $payout->save();

                                    $this->userSuccessNotify($payout);
                                }
                            } elseif ($apiResponse->event == 'payout.rejected' || $apiResponse->event == 'payout.failed') {
                                $payout->status = 4;
                                $payout->last_error = $apiResponse->payload->payout->entity->status_details->description ?? '';
                                $payout->save();

                                $user->balance += $payout->net_amount;
                                $user->save();

                                $transaction = new Transaction();
                                $transaction->user_id = $user->id;
                                $transaction->amount = getAmount($payout->net_amount);
                                $transaction->final_balance = $user->balance;
                                $transaction->charge = $payout->charge;
                                $transaction->trx_type = '+';
                                $transaction->remarks = getAmount($payout->amount) . ' ' . $basic->currency . ' withdraw amount has been refunded';
                                $transaction->trx_id = $payout->trx_id;
                                $transaction->save();

                                $this->userFailNotify($payout, $user);
                            }
                        }
                    }
                }
            }
        }
    }


    public function flutterwavePayoutWebhook($apiResponse)
    {
        $basic = (object)config('basic');
        if ($apiResponse) {
            if ($apiResponse->event == 'transfer.completed') {
                if ($apiResponse->data) {
                    $payout = PayoutLog::where('response_id', $apiResponse->data->id)->first();
                    $user = $payout->user;
                    if ($payout) {
                        if ($apiResponse->data->status == 'SUCCESSFUL') {
                            $payout->status = 2;
                            $payout->save();
                            $this->userSuccessNotify($payout);
                        }
                        if ($apiResponse->data->status == 'FAILED') {
                            $payout->status = 4;
                            $payout->last_error = $apiResponse->data->complete_message;
                            $payout->save();

                            $user->balance += $payout->net_amount;
                            $user->save();

                            $transaction = new Transaction();
                            $transaction->user_id = $user->id;
                            $transaction->amount = getAmount($payout->net_amount);
                            $transaction->final_balance = $user->balance;
                            $transaction->charge = $payout->charge;
                            $transaction->trx_type = '+';
                            $transaction->remarks = getAmount($payout->amount) . ' ' . $basic->currency . ' withdraw amount has been refunded';
                            $transaction->trx_id = $payout->trx_id;
                            $transaction->save();

                            $this->userFailNotify($payout, $user);
                        }
                    }
                }
            }
        }
    }


    public function paystackPayoutWebhook($apiResponse)
    {
        $basic = (object)config('basic');
        if ($apiResponse) {
            if ($apiResponse->data) {
                $payout = PayoutLog::where('response_id', $apiResponse->data->id)->first();
                $user = $payout->user;
                if ($payout) {
                    if ($apiResponse->event == 'transfer.success') {
                        $payout->status = 2;
                        $payout->save();
                        $this->userSuccessNotify($payout);

                    } elseif ($apiResponse->event == 'transfer.failed') {
                        $payout->status = 4;
                        $payout->last_error = $apiResponse->data->complete_message;
                        $payout->save();
                        $user->balance += $payout->net_amount;
                        $user->save();

                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->amount = getAmount($payout->net_amount);
                        $transaction->final_balance = $user->balance;
                        $transaction->charge = $payout->charge;
                        $transaction->trx_type = '+';
                        $transaction->remarks = getAmount($payout->amount) . ' ' . $basic->currency . ' withdraw amount has been refunded';
                        $transaction->trx_id = $payout->trx_id;
                        $transaction->save();

                        $this->userFailNotify($payout, $user);
                    }
                }
            }
        }
    }


    public function paypalPayoutWebhook($apiResponse)
    {
        $basic = (object)config('basic');
        if ($apiResponse) {
            if ($apiResponse->batch_header) {
                $payout = PayoutLog::where('response_id', $apiResponse->batch_header->payout_batch_id)->first();
                $user = $payout->user;
                if ($payout) {
                    if ($apiResponse->event_type == 'PAYMENT.PAYOUTSBATCH.SUCCESS' || $apiResponse->event_type == 'PAYMENT.PAYOUTS-ITEM.SUCCEEDED' || $apiResponse->event_type == 'PAYMENT.PAYOUTSBATCH.PROCESSING') {
                        if ($apiResponse->event_type != 'PAYMENT.PAYOUTSBATCH.PROCESSING') {
                            $payout->status = 2;
                            $payout->save();
                            $this->userSuccessNotify($payout);
                        }
                    } else {
                        $payout->status = 4;
                        $payout->last_error = $apiResponse->summary;
                        $payout->save();

                        $user->balance += $payout->net_amount;
                        $user->save();

                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->amount = getAmount($payout->net_amount);
                        $transaction->final_balance = $user->balance;
                        $transaction->charge = $payout->charge;
                        $transaction->trx_type = '+';
                        $transaction->remarks = getAmount($payout->amount) . ' ' . $basic->currency . ' withdraw amount has been refunded';
                        $transaction->trx_id = $payout->trx_id;
                        $transaction->save();

                        $this->userFailNotify($payout, $user);
                    }
                }
            }
        }
    }


    public function userFailNotify($payout, $user)
    {
        $user = $payout->user;
        $basic = (object)config('basic');

        try {
            $this->sendMailSms($user, $type = 'PAYOUT_REJECTED', [
                'method' => optional($payout->method)->name,
                'amount' => getAmount($payout->amount),
                'charge' => getAmount($payout->charge),
                'currency' => $basic->currency,
                'transaction' => $payout->trx_id,
                'feedback' => $payout->feedback
            ]);


            $msg = [
                'amount' => getAmount($payout->amount),
                'currency' => $basic->currency,
            ];
            $action = [
                "link" => '#',
                "icon" => "fa fa-money-bill-alt "
            ];

            $this->userPushNotification($user, 'PAYOUT_REJECTED', $msg, $action);
        } catch (\Exception $e) {

        }

        return 0;
    }

}
