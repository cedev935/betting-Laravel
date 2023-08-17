<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetInvest extends Model
{
    use HasFactory;

    public function betInvestLog()
    {
        return $this->hasMany(BetInvestLog::class,'bet_invest_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
