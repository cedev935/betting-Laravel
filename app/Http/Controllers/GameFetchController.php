<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameFetchController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $query = GameMatch::query();

        $matches = $query->where('status', 1)
            ->when(request('categoryId', false), function ($q, $categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when(request('tournamentId', false), function ($q, $tournamentId) {
                $q->where('tournament_id', $tournamentId);
            })
            ->when(request('matchId', false), function ($q, $matchId) {
                $q->where('id', $matchId);
            })

//            ->where('start_date', '<=', $now)
//            ->where('end_date', '>', $now)
            ->whereHas('gameTeam1')
            ->whereHas('gameTeam2')
            ->whereHas('gameTournament', function ($query) {
                $query->where('status', 1);
            })
            ->whereHas('gameCategory', function ($query) {
                $query->where('status', 1);
            })
            ->orderBy('start_date', 'asc')->with([
                'gameTeam1' => function ($q) {
                    $q->select('id', 'name', 'image');
                },
                'gameTeam2' => function ($q) {
                    $q->select('id', 'name', 'image');
                },
                'gameTournament' => function ($q) {
                    $q->select('id', 'name');
                },
                'gameCategory' => function ($q) {
                    $q->select('id', 'name', 'icon');
                },
                'activeQuestions',
                'activeQuestions.activeGameOptions'
            ])->get()
            ->map(function ($query) {

                return [
                    "id" => $query->id,
                    "start_date" => $query->start_date,
                    "end_date" => $query->end_date,
                    "category_id" => $query->category_id,
                    "tournament_id" => $query->tournament_id,
                    "team1_id" => $query->team1_id,
                    "team2_id" => $query->team1_id,
                    "name" => $query->name,
                    "name_slug" => slug($query->name),
                    "slug" => slug(optional($query->gameTeam1)->name . ' vs ' . optional($query->gameTeam2)->name),
                    'status' => $query->status,
                    'team1' => optional($query->gameTeam1)->name,
                    'team1_img' => getFile(config('location.team.path') . optional($query->gameTeam1)->image),
                    'team2' => optional($query->gameTeam2)->name,
                    'team2_img' => getFile(config('location.team.path') . optional($query->gameTeam2)->image),

                    'game_category' => [
                        'id' => optional($query->gameCategory)->id,
                        'name' => optional($query->gameCategory)->name,
                        'slug' => slug(optional($query->gameCategory)->name),
                        'icon' => optional($query->gameCategory)->icon,
                    ],
                    'game_tournament' => [
                        'id' => optional($query->gameTournament)->id,
                        'name' => optional($query->gameTournament)->name,
                        'slug' => slug(optional($query->gameTournament)->name)
                    ],
                    'totalQuestion' => count($query->activeQuestions),
                    // Get Questions
                    'questions' => $query->activeQuestions->where('end_time', '>', Carbon::now())->map(function ($question) use ($query) {
                        return [
                            'id' => $question->id,
                            'name' => $question->name,
                            'limit' => $question->limit,
                            'end_time' => $question->end_time,
                            'is_unlock' => $question->is_unlock,
                            'status' => $question->status,
                            // Get Options
                            'options' => $question->activeGameOptions->map(function ($option) use ($question, $query) {
                                return [
                                    'id' => $option->id,
                                    'match_id' => $option->match_id,
                                    'category_name' => optional($query->gameCategory)->name,
                                    'category_icon' => optional($query->gameCategory)->icon,
                                    "tournament_name" => optional($query->gameTournament)->name,
                                    "match_name" => optional($query->gameTeam1)->name . ' vs ' . optional($query->gameTeam2)->name,
                                    'question_id' => $option->question_id,
                                    'question_name' => $question->name,
                                    'option_name' => $option->option_name,
                                    'ratio' => (float)$option->ratio,
                                    'is_unlock_question' => $question->is_unlock,
                                    'is_unlock_match' => $query->is_unlock,
                                    'status' => $option->status,
                                ];
                            })
                        ];
                    })
                ];
            });

        $list =  $matches->where('start_date', '<=', $now)->where('end_date', '>', $now);
        $upcoming = $matches->where('start_date', '>', $now)->where('end_date', '>', $now)->values();


        return response([
            'liveList' => $list,
            'upcomingList' => $upcoming,
        ], 200);
    }
}
