<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\BetInvest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\BasicService;
use Illuminate\Support\Str;

class ManageBetController extends Controller
{
    use Upload, Notify;
    public function betList($user_id = null)
    {
        if ($user_id != null) {
            $data['betInvests'] = BetInvest::with('betInvestLog', 'user')->whereUserId($user_id)->orderBy('id', 'desc')->paginate(config('basic.paginate'));
        } else {
            $data['betInvests'] = BetInvest::with('betInvestLog', 'user')->orderBy('id', 'desc')->paginate(config('basic.paginate'));
        }
        return view('admin.bet_history.index', $data);
    }

    public function betSearch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $betInvest = BetInvest::with('betInvestLog', 'user')
            ->when(isset($search['search']), function ($query) use ($search) {
                $query->whereHas('user', function ($qq) use ($search) {
                    $qq->where('username', 'like', "%" . $search['search'] . "%");
                    $qq->OrWhere('email', 'like', "%" . $search['search'] . "%");
                });
                $query->orWhere('transaction_id','like', "%" . $search['search'] . "%");
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->orderBy('id', 'desc')
            ->paginate(config('basic.paginate'));
        $data['betInvests'] = $betInvest->appends($search);
        return view('admin.bet_history.index', $data);
    }

    public function betRefund(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'betInvestId' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }


        $betInvestId = $request->betInvestId;
        $invest = BetInvest::with('user')->find($betInvestId);

        $basic = (object) config('basic');

        if(!$invest || $invest->status != 0){
            return back()->with('error', 'Invalid Request');
        }

        if($invest->isMultiBet == 1){
            $detail = $invest->betInvestLog;
            $detail->map(function ($sBet){
                $sBet->status = 3;
                $sBet->update();
            });
        }

        DB::beginTransaction();
        $charge = ($invest->invest_amount * $basic->refund_charge)/100;
        $user = $invest->user;
        $user->balance += ($invest->invest_amount- $charge);
        $user->save();



        $invest->charge = getAmount($charge);
        $invest->status = 2;
        $invest->creator_id = Auth()->guard('admin')->id();
        $invest->save();

        $amount=getAmount($invest->invest_amount - $charge);
        $remark=$invest->invest_amount . ' ' . $basic->currency . " refunded by admin policy.";

        BasicService::makeTransaction($user,$amount,$charge,'+',$invest->transaction_id,$remark);
        DB::commit();

        $this->sendMailSms($user, 'USER_REFUND',[
            'amount' => config('basic.currency_symbol').$amount
        ]);

        $msg = [
            'amount' => config('basic.currency_symbol').$amount
        ];
        $action = [
            "link" => '#',
            "icon" => "fas fa-file-alt text-white"
        ];
        $this->userPushNotification($user, 'USER_REFUND', $msg, $action);

        return back()->with('success', 'Refund Successfully');
    }
}
