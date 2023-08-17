<?php

namespace App\Console\Commands;

use App\Http\Traits\Notify;
use App\Models\PayoutLog;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BinanceGetStatus extends Command
{
    use Notify;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout-status:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron for Binance Status';

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
        $basic = (object)config('basic');
        $methodObj = 'App\\Services\\Payout\\binance\\Card';
        $data = $methodObj::getStatus();
        if ($data) {
            $apiResponses = collect($data);
            $binaceIds = $apiResponses->pluck('id');
            $payouts = PayoutLog::whereIn('response_id', $binaceIds)->where('status', 1)->get();
            foreach ($payouts as $payout) {
                $user = $payout->user;
                foreach ($apiResponses as $apiResponse) {
                    if ($payout->response_id == $apiResponse->id) {
                        $status = $apiResponse->status;
                        if ($status == 6) {
                            $payout->status = 2;
                            $payout->save();
                            $binance = new BinanceGetStatus();
                            $binance->userSuccessNotify($payout);

                        } elseif ($status == 1 || $status == 3 || $status == 5) {
                            $payout->status = 4;
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


                            $binance = new BinanceGetStatus();
                            $binance->userFailNotify($payout, $user);
                        }
                        break;
                    }
                }
            }
        }
        return 0;
    }


    public function userSuccessNotify($payout)
    {
        $user = $payout->user;
        $basic = (object)config('basic');

        try {
            $this->sendMailSms($user, 'PAYOUT_APPROVE', [
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
                "link" => route('user.payout.history'),
                "icon" => "fa fa-money-bill-alt "
            ];
            $this->userPushNotification($user, 'PAYOUT_APPROVE', $msg, $action);
        } catch (\Exception $e) {

        }
        return 0;
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
                "link" => route('user.payout.history'),
                "icon" => "fa fa-money-bill-alt "
            ];

            $this->userPushNotification($user, 'PAYOUT_REJECTED', $msg, $action);
        } catch (\Exception $e) {

        }
        return 0;
    }

}
