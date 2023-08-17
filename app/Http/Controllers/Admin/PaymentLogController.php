<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Models\Fund;
use Facades\App\Services\BasicService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;

class PaymentLogController extends Controller
{
    use Notify;

    public function index()
    {
        $page_title = "Payment Logs";
        $funds = Fund::where('status', '!=', 0)->orderBy('id', 'DESC')->with('user', 'gateway')->paginate(config('basic.paginate'));
        return view('admin.payment.logs', compact('funds', 'page_title'));
    }

    public function pending()
    {
        $page_title = "Payment Pending";
        $funds = Fund::where('status', 2)->where('gateway_id', '>', 999)->orderBy('id', 'DESC')->with('user', 'gateway')->paginate(config('basic.paginate'));
        return view('admin.payment.logs', compact('funds', 'page_title'));
    }


    public function search(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $funds = Fund::when(isset($search['name']), function ($query) use ($search) {
            return $query->where('transaction', 'LIKE', $search['name'])
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search['name']}%")
                        ->orWhere('username', 'LIKE', "%{$search['name']}%");
                });
        })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when($search['status'] != -1, function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->where('status', '!=', 0)
            ->with('user', 'gateway')
            ->paginate(config('basic.paginate'));
        $funds->appends($search);
        $page_title = "Search Payment Logs";
        return view('admin.payment.logs', compact('funds', 'page_title'));
    }


    public function action(Request $request, $id)
    {

        $this->validate($request, [
            'id' => 'required',
            'status' => ['required', Rule::in(['1', '3'])],
        ]);
        $data = Fund::where('id', $request->id)->whereIn('status', [2])->with('user', 'gateway')->firstOrFail();
        $basic = (object)config('basic');

        $req = Purify::clean($request->all());

        if ($request->status == '1') {
            $data->status = 1;
            $data->feedback = @$req['feedback'];
            $data->update();

            $user = $data->user;
            $user->balance += $data->amount;
            $user->save();

            $remarks = getAmount($data->amount) . ' ' . $basic->currency . ' payment amount has been approved';
            BasicService::makeTransaction($user, getAmount($data->amount), getAmount($data->charge),  '+', $data->transaction, $remarks);
			
			if ($basic->deposit_commission == 1) {
                BasicService::setBonus($user, getAmount($data->amount), 'deposit');
            }


            $this->sendMailSms($user, 'PAYMENT_APPROVED', [
                'gateway_name' => $data->gateway->name,
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $basic->currency,
                'transaction' => $data->transaction,
                'feedback' => $data->feedback,
            ]);


            $msg = [
                'amount' => getAmount($data->amount),
                'currency' => $basic->currency,
            ];
            $action = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($user, 'PAYMENT_APPROVED', $msg, $action);


            session()->flash('success', 'Approve Successfully');
            return back();

        } elseif ($request->status == '3') {

            $data->status = 3;
            $data->feedback = $request->feedback;
            $data->update();
            $user = $data->user;

            $this->sendMailSms($user, $type = 'DEPOSIT_REJECTED', [
                'amount' => getAmount($data->amount),
                'currency' => $basic->currency,
                'method' => optional($data->gateway)->name,
                'transaction' => $data->transaction,
                'feedback' => $data->feedback
            ]);

            $msg = [
                'amount' => getAmount($data->amount),
                'currency' => $basic->currency,
                'feedback' => $data->feedback,
            ];
            $action = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($user, 'PAYMENT_REJECTED', $msg, $action);

            session()->flash('success', 'Reject Successfully');
            return back();
        }
    }
}
