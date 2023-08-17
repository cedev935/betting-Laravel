<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameOption extends Model
{
    use HasFactory;

    public function gameMatch()
    {
        return $this->belongsTo(GameMatch::class,'match_id');
    }
    public function gameQuestion()
    {
        return $this->belongsTo(GameQuestions::class,'question_id');
    }
    public function betInvestLog()
    {
        return $this->hasMany(BetInvestLog::class,'bet_option_id');
    }

    public function betOptions()
    {
        return $this->hasMany(BetInvestLog::class,'bet_option_id');
    }
}
