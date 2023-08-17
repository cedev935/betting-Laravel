<?php

namespace App\Http\Controllers\Admin;

use App\Events\MatchNotification;
use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Models\GameMatch;
use App\Models\GameOption;
use App\Models\GameQuestions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MatchOptionController extends Controller
{
    use Notify;

    public function optionList($question_id)
    {
        $gameOption = DB::table('game_options')->where('question_id', $question_id)->orderBy('id', 'desc')->get();
        return $gameOption;
    }

    public function optionUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'option_name' => 'required',
            'ratio' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }
        $data = GameOption::find($request->id);

        if ($data->gameQuestion->result == 1) {
            return response()->json(['error' => 'Question result Over']);
        }

        $data->option_name = $request->option_name;
        $data->ratio = $request->ratio;
        $data->status = $request->status;
        $data->save();

        $query = $data->gameMatch;
        $this->matchEvent($query);
        return response()->json(['result' => $data]);
    }

    public function optionAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'match_id' => 'required',
            'option_name' => 'required',
            'ratio' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }
        $data = new GameOption();
        $data->match_id = $request->match_id;
        $data->question_id = $request->question_id;
        $data->option_name = $request->option_name;
        $data->ratio = $request->ratio;
        $data->status = $request->status;
        $data->creator_id = Auth::guard('admin')->id();
        $data->save();

        $query = $data->gameMatch;
        $this->matchEvent($query);

        return response()->json(['result' => $data]);
    }

    public function questionLocker(Request $request)
    {
        $gameQuestion = GameQuestions::find($request->question_id);

        if ($gameQuestion->result == 1) {
            return back()->with('error', 'Question Result Over');
        }
        if ($gameQuestion->is_unlock == 1) {
            $gameQuestion->is_unlock = 0;
            session()->flash('success', 'Question has been unlocked');
        } else {
            $gameQuestion->is_unlock = 1;

            session()->flash('info', 'Question has been locked');
        }
        $gameQuestion->save();


        $query = $gameQuestion->gameMatch;
        $this->matchEvent($query);

        return back();
    }


    public function optionDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }
        $data = GameOption::withCount('betOptions')->findOrFail($request->id);

        $query = $data->gameMatch;

        if (0 < $data->bet_options_count) {
            return response()->json([
                'success' => false,
                'result' => "This item has a lot of Bets. You can't delete this"
            ]);
        }
        $data->delete();

        $this->matchEvent($query);
        return response()->json(['result' => '', 'success' => true]);
    }

}
