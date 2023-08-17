<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTeam extends Model
{
    use HasFactory;

    public function gameCategory()
    {
        return $this->belongsTo(GameCategory::class,'category_id' );
    }
    public function gameTeam1()
    {
        return $this->hasMany(GameMatch::class,'team1_id');
    }
    public function gameTeam2()
    {
        return $this->hasMany(GameMatch::class,'team2_id');
    }
}
