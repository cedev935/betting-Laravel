<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BetInvestLog;
use App\Models\GameOption;
use App\Models\GameQuestions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Facades\App\Services\BasicService;
class ManageResultController extends Controller
{
    public function resultList(Request $request)
    {
        $routeName = Route::currentRouteName();
        if ($routeName == 'admin.resultList.pending') {
            $data['gameQuestions'] = GameQuestions::with(['gameMatch.gameTeam1', 'gameMatch.gameTeam2', 'betInvestLog.betInvest'])
                ->withCount('betInvestLog')
                ->whereResult(0)
                ->whereIn('status', ['0', '1'])
                ->orderBy('id', 'desc')->paginate(config('basic.paginate'));
        } else {
            $data['gameQuestions'] = GameQuestions::with(['gameMatch.gameTeam1', 'gameMatch.gameTeam2', 'betInvestLog.betInvest'])
                ->withCount('betInvestLog')
                ->where('result', 1)
                ->orderBy('id', 'desc')
                ->paginate(config('basic.paginate'));
        }

        return view('admin.result_history.index', $data);
    }

    public function resultSearch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $gameQuestion = GameQuestions::with(['gameMatch.gameTeam1', 'gameMatch.gameTeam2', 'betInvestLog.betInvest'])
            ->when(isset($search['search']), function ($query) use ($search) {
                $query->whereHas('gameMatch.gameTeam1', function ($qq) use ($search) {
                    $qq->where('name', 'like', "%" . $search['search'] . "%");
                })
                    ->orWhereHas('gameMatch.gameTeam2', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%" . $search['search'] . "%");
                    });
                $query->orwhere('name', 'like', "%" . $search['search'] . "%");
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("end_time", $dateSearch);
            })
            ->withCount('betInvestLog')
            ->orderBy('id', 'desc')
            ->paginate(config('basic.paginate'));

        $data['gameQuestions'] = $gameQuestion->appends($search);
        return view('admin.result_history.index', $data);

    }

    public function resultWinner($id)
    {
        $data['gameQuestion'] = GameQuestions::with('gameOptions')->findOrFail($id);
        return view('admin.result_history.optionList', $data);
    }

    public function makeWinner(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'optionId' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        DB::beginTransaction();
        $betOptionId = $request->optionId;
        $betOption = GameOption::with('gameMatch', 'gameQuestion')->findOrFail($betOptionId);

        $question = $betOption->gameQuestion;

        if ($question->result == 1) {
            return back()->with('error', 'Invalid Request, Reload the page');
        }
        $question->betInvestLog();

        //Winner Declare
        $question->betInvestLog()->where('bet_option_id', $betOptionId)->where('status', 0)->get()->map(function ($winner) use ($betOption, $question) {
            $winner->status = 2;
            $winner->update();

        });

        //Loser Declare
        $question->betInvestLog()->where('bet_option_id', '!=', $betOptionId)->where('status', 0)->get()->map(function ($loser) use ($betOption, $question) {
            $loser->status = -2;
            $loser->update();
        });

        $question->result = 1; // Question Result Declare
        $question->save();

        $betOption->status = 2;  // Option Result Declare
        $betOption->update();

        $question->gameOptions()->where('id', '!=', $betOptionId)->get()->map(function ($item) {
            $item->status = -2;
            $item->update();
        });

        DB::commit();
        return back()->with('success', 'Winner Make Successfully');

    }

    public function refundQuestion(Request $request, $id)
    {
        $basic = (object) config('basic');
        $question = GameQuestions::with(['gameMatch.gameTeam1', 'gameMatch.gameTeam2', 'gameOptions','betInvestLog.betInvest','betInvestLog.user'])
            ->whereResult(0)
            ->withCount('betInvestLog')
            ->findOrFail($id);

        $question->result = 1;
        $question->save();
        $detail = $question->betInvestLog;

        $question->gameOptions->map(function ($item){
            $item->status = 3;
            $item->save();
            return $item;
        });

        foreach ($detail as $value) {
            if($value->status == 3){
                continue;
            }else{
                $rootBetInvest = $value->betInvest;

                $value->status = 3;  // refunded
                $value->save();

                if($rootBetInvest->isMultiBet == 1){
                    $newRatio = $rootBetInvest->ratio/$value->ratio;
                    $rootBetInvest->ratio = $newRatio;
                    $rootBetInvest->return_amount = $rootBetInvest->invest_amount * $newRatio;
                    $rootBetInvest->save();
                }else{
                    $user = $value->user;
                    $charge = ($rootBetInvest->invest_amount * $basic->refund_charge)/100;
                    $user->balance += ($rootBetInvest->invest_amount- $charge);
                    $user->save();

                    $rootBetInvest->status = 2;
                    $rootBetInvest->save();

                    $title =  $rootBetInvest->invest_amount . ' ' . $basic->currency . " refunded by admin policy on ".$rootBetInvest->transaction_id;
                    $trx = strRandom();
                    BasicService::makeTransaction($user, getAmount($rootBetInvest->invest_amount- $charge), getAmount($charge), '+', $trx, $title);
                }

            }

        }
        return back()->with('success', 'Investor Amount has been refunded');
    }

    public function betUser($questionId)
    {

        $question = GameQuestions::with(['gameMatch.gameTeam1:id,name', 'gameMatch.gameTeam2:id,name'])->findOrFail($questionId);
        $data['betInvestLogs'] = BetInvestLog::with(['user', 'gameQuestion.winOption', 'gameOption'])->where('question_id', $questionId)->orderBy('id', 'desc')->paginate(config('basic.paginate'));

        $data['question'] = $question;
        $data['matchName'] = @$question->gameMatch->gameTeam1->name .' VS '. @$question->gameMatch->gameTeam2->name;
        return view('admin.result_history.userList', $data);
    }
}
