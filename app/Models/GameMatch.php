<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    use HasFactory;
    public function gameCategory()
    {
        return $this->belongsTo(GameCategory::class,'category_id');
    }
    public function gameTournament()
    {
        return $this->belongsTo(GameTournament::class,'tournament_id');
    }
    public function gameTeam1()
    {
        return $this->belongsTo(GameTeam::class,'team1_id');
    }
    public function gameTeam2()
    {
        return $this->belongsTo(GameTeam::class,'team2_id');
    }
    public function gameQuestions()
    {
        return $this->hasMany(GameQuestions::class,'match_id');
    }
    public function activeQuestions()
    {
        return $this->hasMany(GameQuestions::class,'match_id')->where('status',1);
    }



}
