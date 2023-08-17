<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameCategory;
use App\Models\GameTournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class TournamentController extends Controller
{
    public function listTournament()
    {
        $data['tournaments'] = GameTournament::with('gameCategory')->orderBy('id','desc')->get();
        $data['categories'] = GameCategory::whereStatus(1)->orderBy('name','asc')->get();
        return view('admin.tournament.list', $data);
    }

    public function storeTournament(Request $request)
    {

        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));
        $rules = [
            'name' => 'required|max:40',
            'category' => 'required',
        ];
        $message = [
            'name.required' => 'Name field is required',
            'category.required' => 'Category field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try{

            $gameTournament = new GameTournament();

            if ($request->has('name')) {
                $gameTournament->name = @$purifiedData['name'];
            }
            if ($request->has('category')) {
                $gameTournament->category_id = $request->category;
            }

            $gameTournament->status = isset($purifiedData['status']) == 'true' ? 1 : 0;

            $gameTournament->save();
            return back()->with('success', 'Successfully Saved');

        }catch (\Exception $e){
            return back();
        }
    }

    public function updateTournament(Request $request,$id)
    {
        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));
        $rules = [
            'name' => 'required|max:40',
            'category' => 'required',
        ];
        $message = [
            'name.required' => 'Name field is required',
            'category.required' => 'Category field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        try{
            $gameTournament = GameTournament::findOrFail($id);

            if ($request->has('name')) {
                $gameTournament->name = @$purifiedData['name'];
            }

            if ($request->has('category')) {
                $gameTournament->category_id = $request->category;
            }

            $gameTournament->status = isset($purifiedData['status']) == 'true' ? 1 : 0;

            $gameTournament->save();
            return back()->with('success', 'Successfully Updated');

        }catch (\Exception $e){
            return back();
        }
    }

    public function deleteTournament($id)
    {
        $gameTournament = GameTournament::with('gameMatch')->findOrFail($id);

        if (0 < count($gameTournament->gameMatch)) {
            session()->flash('warning', 'This tournament has a lot of match');
            return back();
        }

        $gameTournament->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function activeMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            GameTournament::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Tournament Has Been Active');
            return response()->json(['success' => 1]);
        }

    }

    public function deActiveMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            GameTournament::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);
            session()->flash('success', 'Tournament Has Been Deactive');
            return response()->json(['success' => 1]);
        }
    }
}
