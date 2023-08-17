<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameQuestions extends Model
{
    use HasFactory;
    public function gameOptions()
    {
        return $this->hasMany(GameOption::class,'question_id');
    }


    public function gameOptionResult()
    {
        return $this->hasOne(GameOption::class,'question_id')->where('status',2);
    }

    public function activeGameOptions()
    {
        return $this->hasMany(GameOption::class,'question_id')->where('status',1);
    }
    public function winOption()
    {
        return $this->hasOne(GameOption::class,'question_id')->where('status',2);
    }
    public function gameMatch()
    {
        return $this->belongsTo(GameMatch::class,'match_id');
    }

    public function betInvestLog()
    {
        return $this->hasMany(BetInvestLog::class,'question_id');
    }
    public function betSum()
    {
        return $this->hasManyThrough(BetInvest::class,BetInvestLog::class,'id','bet_invest_id')->sum('invest_amount');
    }

}
