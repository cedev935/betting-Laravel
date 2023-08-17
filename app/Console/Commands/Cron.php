<?php

namespace App\Console\Commands;

use App\Http\Traits\Notify;
use App\Models\BetInvest;
use App\Models\GameMatch;
use App\Models\GameQuestions;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Facades\App\Services\BasicService;

class Cron extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron for investment Status';

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
        $now = Carbon::now();
        $basic = (object)config('basic');
        BetInvest::where('status', 0)
            ->whereHas('user')
            ->whereHas('betInvestLog')
            ->with(['user', 'betInvestLog'])->get()->map(function ($item) use ($basic) {

            $detail = $item->betInvestLog;

            $total = count($detail);
            $win = count($detail->where('status', 2));
            $lose = count($detail->where('status', -2));
            $refund = count($detail->where('status', 3));
            if ($total == ($win + $refund)) {
                if($total != $refund){
                    //// Win
                    $return_amo = $item->return_amount;
                    $charge = (($item->return_amount - $item->invest_amount) * $basic->win_charge) / 100; //percent
                    $user = $item->user;

                    $title = "You are win  $total Threats";
                    $user->balance += round(($return_amo - $charge), 2);
                    $user->save();

                    $item->status = 1;
                    $item->creator_id = null;
                    $item->charge = round($charge, 2);
                    $item->update();
                    BasicService::makeTransaction($user, round(($return_amo - $charge), 2), $charge, '+',  $item->transaction_id,  $title);

                    if ($basic->bet_win_commission == 1) {
                        BasicService::setBonus($user, getAmount($return_amo - $charge), 'bet_win');
                    }

                    $this->sendMailSms($user, 'BET_WIN', [
                        'transaction_id' => $item->transaction_id,
                        'amount' => $return_amo - $charge,
                        'currency' => $basic->currency_symbol,
                        'final_balance' => $user->balance,
                    ]);
                }

            }
            elseif ($total == ($win + $lose + $refund)) {
                $item->status = -1;
                $item->creator_id = null;
                $item->update();
            }
        });


        GameMatch::where('status',1)->where('end_date', '<', $now)->get()->map(function ($item){
            $item->status = 2;
            $item->save();
        });

        GameQuestions::where('status',1)->where('end_time', '<', $now)->get()->map(function ($item){
            $item->status = 2;
            $item->save();
        });



        $this->info('status');
    }

}
