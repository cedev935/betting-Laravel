<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetInvestLog extends Model
{
    use HasFactory;
    protected $table= "bet_invest_logs";
    protected $guarded = ['id'];

    public function betInvest()
    {
        return $this->belongsTo(BetInvest::class,'bet_invest_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function gameQuestion()
    {
        return $this->belongsTo(GameQuestions::class,'question_id');
    }

    public function gameOption()
    {
        return $this->belongsTo(GameOption::class,'bet_option_id');
    }
}
