<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\BetInvest;
use App\Models\GameMatch;
use App\Models\GameQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BetHistoryController extends Controller
{
    use Upload, Notify;
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }
    public function betList()
    {
        $data['betInvests'] = BetInvest::with('betInvestLog')->where('user_id',$this->user->id)->orderBy('id','desc')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.betHistory.index',$data);
    }

}
