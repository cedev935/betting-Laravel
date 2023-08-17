<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\BetInvest;
use App\Models\Configure;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\PayoutLog;
use App\Models\Referral;
use App\Models\Subscriber;
use App\Models\Ticket;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    use Upload;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    public function forbidden()
    {
        return view('admin.errors.403');
    }


    public function dashboard()
    {
        $data['subscriber'] = Subscriber::count();
        $data['funding'] = collect(Fund::selectRaw('SUM(CASE WHEN status = 1 THEN amount END) AS totalAmountReceived')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN charge END) AS totalChargeReceived')
            ->selectRaw('SUM((CASE WHEN created_at >= CURDATE() AND status = 1 THEN amount END)) AS todayDeposit')
            ->get()->toArray())->collapse();

        $data['userRecord'] = collect(User::selectRaw('COUNT(id) AS totalUser')
            ->selectRaw('count(CASE WHEN status = 1  THEN id END) AS activeUser')
            ->selectRaw('SUM(balance) AS totalUserBalance')
            ->selectRaw('COUNT((CASE WHEN created_at >= CURDATE()  THEN id END)) AS todayJoin')
            ->get()->makeHidden(['fullname', 'mobile'])->toArray())->collapse();


        $data['tickets'] = collect(Ticket::where('created_at', '>', Carbon::now()->subDays(30))
            ->selectRaw('count(CASE WHEN status = 3  THEN status END) AS closed')
            ->selectRaw('count(CASE WHEN status = 2  THEN status END) AS replied')
            ->selectRaw('count(CASE WHEN status = 1  THEN status END) AS answered')
            ->selectRaw('count(CASE WHEN status = 0  THEN status END) AS pending')
            ->get()->toArray())->collapse();



        $dailyInvestAmo = $this->dayList();
        $dailyInvest = $this->dayList();
        $dailyReturn = $this->dayList();
        $dailyRefund = $this->dayList();
        BetInvest::whereMonth('created_at', Carbon::now()->month)
            ->select(
                DB::raw('sum(invest_amount) as total_Amount'),
                DB::raw('sum(CASE WHEN status != 2 THEN invest_amount END) as Invest_Amount'),
                DB::raw('sum(CASE WHEN status = 1 THEN return_amount END) as Return_Amount'),
                DB::raw('sum(CASE WHEN status = 2 THEN invest_amount END) as Refund_Amount'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyInvestAmo, $dailyInvest, $dailyReturn, $dailyRefund) {
                $dailyInvestAmo->put($item['date'], round($item['total_Amount'], 2));
                $dailyInvest->put($item['date'], round($item['Invest_Amount'], 2));
                $dailyReturn->put($item['date'], round($item['Return_Amount'], 2));
                $dailyRefund->put($item['date'], round($item['Refund_Amount'], 2));
            });

        $statistics['investment'] = $dailyInvest;
        $statistics['return'] = $dailyReturn;
        $statistics['refund'] = $dailyRefund;


        $dailyDeposit = $this->dayList();
        Fund::whereMonth('created_at', Carbon::now()->month)
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->where('status',1)
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyDeposit) {
                $dailyDeposit->put($item['date'], round($item['totalAmount'], 2));
            });
        $statistics['deposit'] = $dailyDeposit;


        $dailyPayout = $this->dayList();
        PayoutLog::whereMonth('created_at', Carbon::now()->month)
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->where('status',2)
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyPayout) {
                $dailyPayout->put($item['date'], round($item['totalAmount'], 2));
            });
        $statistics['payout'] = $dailyPayout;
        $statistics['schedule'] = $this->dayList();


        /*
        * Pie Chart Data
        */
        $gateway = Gateway::count('id');
        $pieLog = collect();

        Fund::where('status',1)->with('gateway:id,name')
            ->get()->groupBy('gateway.name')->map(function ($items, $key) use ($gateway, $pieLog) {
                $pieLog->push(['level' => $key, 'value' => round((0 < $gateway) ? (count($items) / $gateway * 100) : 0, 2)]);
                return $items;
            });





        $data['payout'] = collect(PayoutLog::selectRaw('COUNT(CASE WHEN status = 1  THEN id END) AS pending')
            ->selectRaw('SUM((CASE WHEN status = 2 AND created_at >= CURDATE()  THEN amount END)) AS todayPayoutAmount')
            ->selectRaw('SUM((CASE WHEN status = 2 AND created_at >=  DATE_SUB(CURRENT_DATE() , INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) THEN amount END)) AS monthlyPayoutAmount')
            ->selectRaw('SUM((CASE WHEN status = 2 AND created_at >=  DATE_SUB(CURRENT_DATE() , INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) THEN charge END)) AS monthlyPayoutCharge')
            ->get()->toArray())->collapse();

        $data['latestUser'] = User::latest()->limit(5)->get();

        return view('admin.dashboard', $data, compact('statistics', 'pieLog','statistics'));
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


    public function referralCommission()
    {
        $data['referrals'] = Referral::get();
        $data['control'] = Configure::firstOrNew();
        return view('admin.referral-commission', $data);

    }

    public function referralCommissionStore(Request $request)
    {
        $request->validate([
            'level*' => 'required|integer|min:1',
            'percent*' => 'required|numeric',
            'commission_type' => 'required',
        ]);

        Referral::where('commission_type',$request->commission_type)->delete();

        for ($i = 0; $i < count($request->level); $i++){
            $referral = new Referral();
            $referral->commission_type = $request->commission_type;
            $referral->level = $request->level[$i];
            $referral->percent = $request->percent[$i];
            $referral->save();
        }

        return back()->with('success', 'Level Bonus Has been Updated.');
    }


    public function referralCommissionAction(Request $request)
    {
        $configure = Configure::firstOrNew();
        $reqData = Purify::clean($request->except('_token', '_method'));


        config(['basic.deposit_commission' => (int)$reqData['deposit_commission']]);
        config(['basic.bet_commission' => (int)$reqData['bet_commission']]);
        config(['basic.bet_win_commission' => (int)$reqData['bet_win_commission']]);
        $configure->fill($reqData)->save();


        $fp = fopen(base_path() . '/config/basic.php', 'w');
        fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
        fclose($fp);

        return back()->with('success', 'Update Successfully.');
    }

    public function profile()
    {
        $admin = $this->user;
        return view('admin.profile', compact('admin'));
    }


    public function profileUpdate(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));
        $rules = [
            'name' => 'sometimes|required',
            'username' => 'sometimes|required|unique:admins,username,' . $this->user->id,
            'email' => 'sometimes|required|email|unique:admins,email,' . $this->user->id,
            'phone' => 'sometimes|required',
            'address' => 'sometimes|required',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = $this->user;
        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = $this->uploadImage($request->image, config('location.admin.path'), config('location.admin.size'), $old);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }
        $user->name = $req['name'];
        $user->username = $req['username'];
        $user->email = $req['email'];
        $user->phone = $req['phone'];
        $user->address = $req['address'];
        $user->save();

        return back()->with('success', 'Updated Successfully.');
    }


    public function password()
    {
        return view('admin.password');
    }

    public function passwordUpdate(Request $request)
    {
        $req = Purify::clean($request->all());

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $request = (object)$req;
        $user = $this->user;
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', "Password didn't match");
        }
        $user->update([
            'password' => bcrypt($request->password)
        ]);
        return back()->with('success', 'Password has been Changed');
    }



}
