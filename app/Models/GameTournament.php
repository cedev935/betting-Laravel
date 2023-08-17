<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTournament extends Model
{
    use HasFactory;

    public function gameCategory()
    {
        return $this->belongsTo(GameCategory::class,'category_id' );
    }
    public function gameMatch()
    {
        return $this->hasMany(GameMatch::class,'tournament_id');
    }
}
