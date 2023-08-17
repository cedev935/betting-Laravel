<?php

namespace App\Http\Controllers\Admin;

use App\Events\MatchNotification;
use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\GameCategory;
use App\Models\GameMatch;
use App\Models\GameOption;
use App\Models\GameQuestions;
use App\Models\GameTeam;
use App\Models\GameTournament;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    use Upload, Notify;

    public function listMatch(Request $request)
    {
        $data['matches'] = GameMatch::with(['gameCategory', 'gameTournament', 'gameTeam1', 'gameTeam2'])->withCount('activeQuestions')->orderBy('id', 'desc')->paginate(config('basic.paginate'));
        $data['tournaments'] = GameTournament::with('gameCategory')->whereStatus(1)->orderBy('name', 'asc')->get();
        $data['categories'] = GameCategory::whereStatus(1)->orderBy('name', 'asc')->get();
        return view('admin.match.list', $data);
    }


    public function searchMatch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $matches = GameMatch::with(['gameCategory', 'gameTournament', 'gameTeam1', 'gameTeam2'])
            ->when(isset($search['search']), function ($query) use ($search) {
                $query->whereHas('gameTeam1', function ($qq) use ($search) {
                    $qq->where('name', 'like', "%" . $search['search'] . "%");
                })
                    ->orWhereHas('gameTeam2', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%" . $search['search'] . "%");
                    });
            })


            ->when(isset($search['searchCategory']), function ($query) use ($search) {
                $query->whereHas('gameCategory', function ($qq) use ($search) {
                    $qq->where('id', $search['searchCategory']);
                });
            })

            ->when(isset($search['searchTournament']), function ($query) use ($search) {
                $query->whereHas('gameTournament', function ($qq) use ($search) {
                    $qq->where('id', $search['searchTournament']);
                });
            })

            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->withCount('activeQuestions')
            ->paginate(config('basic.paginate'));
        $data['matches'] = $matches->appends($search);

        $data['tournaments'] = GameTournament::whereStatus(1)->with('gameCategory')->orderBy('name', 'asc')->get();
        $data['categories'] = GameCategory::whereStatus(1)->orderBy('name', 'asc')->get();

        return view('admin.match.list', $data);
    }


    public function ajaxListMatch(Request $request)
    {
        $team = GameTeam::where('category_id', $request->categoryId)->orderBy('name')->get();
        $tournament = GameTournament::where('category_id', $request->categoryId)->orderBy('name')->get();
        return [
            'team' => $team,
            'tournament' => $tournament,
        ];
    }

    public function storeMatch(Request $request)
    {

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'category' => 'required',
            'tournament' => 'required',
            'team1' => 'required',
            'team2' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $message = [
            'category.required' => 'Category field is required',
            'tournament.required' => 'Tournament field is required',
            'team1.required' => 'Team 1 field is required',
            'team2.required' => 'Team 2 field is required',
            'start_date.required' => 'Start date field is required',
            'end_date.required' => 'End date field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            $gameMatch = new GameMatch();
            if ($request->has('category')) {
                $gameMatch->category_id = @$purifiedData['category'];
            }
            if ($request->has('tournament')) {
                $gameMatch->tournament_id = @$purifiedData['tournament'];
            }
            if ($request->has('team1')) {
                $gameMatch->team1_id = @$purifiedData['team1'];
            }
            if ($request->has('team2')) {
                $gameMatch->team2_id = @$purifiedData['team2'];
            }
            if ($request->has('start_date')) {
                $gameMatch->start_date = @$purifiedData['start_date'];
            }
            if ($request->has('end_date')) {
                $gameMatch->end_date = @$purifiedData['end_date'];
            }
            if ($request->has('name')) {
                $gameMatch->name = @$purifiedData['name'];
            }

            $gameMatch->status = isset($purifiedData['status']) == 'true' ? 1 : 0;
            $gameMatch->save();


            $query = $gameMatch;
            if (Carbon::parse($gameMatch->start_date) > Carbon::now()) {
                $type = 'UpcomingList';
            } else {
                $type = 'Enlisted';
            }
            $this->matchEvent($query, $type);
            return back()->with('success', 'Successfully Saved');

        } catch (\Exception $e) {
            return back();
        }
    }

    public function updateMatch(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));
        $rules = [
            'category' => 'required',
            'tournament' => 'required',
            'team1' => 'required',
            'team2' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $message = [
            'category.required' => 'Category field is required',
            'tournament.required' => 'Tournament field is required',
            'team1.required' => 'Team 1 field is required',
            'team2.required' => 'Team 2 field is required',
            'start_date.required' => 'Start date field is required',
            'end_date.required' => 'End date field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            $gameMatch = GameMatch::findOrFail($id);

            if ($request->has('category')) {
                $gameMatch->category_id = @$purifiedData['category'];
            }
            if ($request->has('tournament')) {
                $gameMatch->tournament_id = @$purifiedData['tournament'];
            }
            if ($request->has('team1')) {
                $gameMatch->team1_id = @$purifiedData['team1'];
            }
            if ($request->has('team2')) {
                $gameMatch->team2_id = @$purifiedData['team2'];
            }
            if ($request->has('start_date')) {
                $gameMatch->start_date = @$purifiedData['start_date'];
            }
            if ($request->has('end_date')) {
                $gameMatch->end_date = @$purifiedData['end_date'];
            }
            if ($request->has('name')) {
                $gameMatch->name = @$purifiedData['name'];
            }

            $gameMatch->status = isset($purifiedData['status']) == 'true' ? 1 : 0;
            $gameMatch->save();


            $query = $gameMatch;

            if (Carbon::parse($gameMatch->start_date) > Carbon::now()) {
                $type = 'UpcomingList';
            } else {
                $type = 'Enlisted';
            }
            $this->matchEvent($query, $type);

            return back()->with('success', 'Successfully Updated');

        } catch (\Exception $e) {
            return back();
        }
    }

    public function deleteMatch($id)
    {
        $gameMatch = GameMatch::withCount('gameQuestions')->findOrFail($id);

        if (0 < $gameMatch->game_questions_count) {
            session()->flash('warning', 'This item has a lot of Question. At first delete those data');
            return back();
        }
        $gameMatch->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function activeMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            GameMatch::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Match Has Been Active');
            return response()->json(['success' => 1]);
        }

    }

    public function deActiveMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            GameMatch::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);
            session()->flash('success', 'Match Has Been Deactive');
            return response()->json(['success' => 1]);
        }
    }

    public function addQuestion($match_id = null)
    {
        $data['match'] = GameMatch::with(['gameTeam1', 'gameTeam2'])->where('status', '!=', '2')->findOrFail($match_id);
        return view('admin.match.freeQuestion', $data);
    }

    public function storeQuestion(Request $request)
    {

        if (!$request->index) {
            session()->flash('warning', 'Invalid Request');
            return back();
        }

        foreach ($request->index as $key => $value) {
            $betQues = new GameQuestions();
            $betQues->match_id = $request->match_id[$value][0];
            $betQues->creator_id = Auth::guard('admin')->id();
            $betQues->name = $request->question[$value][0];
            $betQues->status = $request->question_status[$value][0];
            $betQues->end_time = Carbon::parse($request->end_time[$value][0]);
            $betQues->save();
            if (!empty($request->option_name[$value])) {
                foreach ($request->option_name[$value] as $k => $item) {
                    $betOpt = new GameOption();
                    $betOpt->creator_id = Auth::guard('admin')->id();
                    $betOpt->question_id = $betQues->id;
                    $betOpt->match_id = $betQues->match_id;
                    $betOpt->option_name = $item;
                    $betOpt->ratio = $request->ratio[$value][$k];
                    $betOpt->status = $request->status[$value][$k];
                    $betOpt->save();
                }
            }

        }

        $query = GameMatch::find(collect($request->match_id)->collapse()->first());
        $this->matchEvent($query);

        session()->flash('success', 'Saved  Successfully');
        return back();
    }

    public function infoMatch($match_id)
    {
        $data['match'] = GameMatch::with(['gameTeam1', 'gameTeam2'])->findOrFail($match_id);
        $data['gameQuestions'] = GameQuestions::where('match_id', $match_id)->orderBy('id', 'desc')->paginate(config('basic.paginate'));
        return view('admin.match.questionList', $data);
    }

    public function updateQuestion(Request $request)
    {

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'questionId' => 'required',
            'name' => 'required',
            'status' => 'required',
            'end_time' => 'required',
        ];
        $message = [
            'questionId.required' => 'Something Went Wrong',
            'name.required' => 'Name field is required',
            'status.required' => 'Status field is required',
            'end_time.required' => 'End Time field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try {
            $gameQuestion = GameQuestions::findOrFail($request->questionId);

            if($gameQuestion->result == 1){
                return back()->with('error','Question Result Over');
            }
            $gameQuestion->name = $request->name;
            $gameQuestion->status = $request->status;
            $gameQuestion->end_time = $request->end_time;
            $gameQuestion->save();


            $query = $gameQuestion->gameMatch;
            $this->matchEvent($query);


            session()->flash('success', 'Updated  Successfully');
            return back();

        } catch (\Exception $e) {
            session()->flash('warning', 'Something Went Wrong');
            return back();
        }
    }

    public function deleteQuestion($id)
    {
        $gameQuestion = GameQuestions::withCount('gameOptions')->findOrFail($id);
        if (0 < $gameQuestion->game_options_count) {
            session()->flash('warning', 'This item has a lot of options. At first delete those data');
            return back();
        }
        $gameQuestion->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function activeQsMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            GameQuestions::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Questions Has Been Active');
            return response()->json(['success' => 1]);
        }

    }

    public function deActiveQsMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            GameQuestions::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);
            session()->flash('success', 'Questions Has Been Deactive');
            return response()->json(['success' => 1]);
        }
    }

    public function closeQsMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            GameQuestions::whereIn('id', $request->strIds)->update([
                'status' => 2,
            ]);
            session()->flash('success', 'Questions Has Been Deactive');
            return response()->json(['success' => 1]);
        }
    }

    public function matchLocker(Request $request)
    {
        $gamematch = GameMatch::find($request->match_id);
        if ($gamematch->is_unlock == 1) {
            $gamematch->is_unlock = 0;
            session()->flash('success', 'Match has been unlocked');
        } else {
            $gamematch->is_unlock = 1;

            session()->flash('info', 'Match has been locked');
        }
        $gamematch->save();

        $query = $gamematch;
        $this->matchEvent($query);
        return back();
    }

}
