<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
    use HasFactory;
    protected $table='game_categories';

    public function gameTournament()
    {
        return $this->hasMany(GameTournament::class,'category_id');
    }
    public function gameTeam()
    {
        return $this->hasMany(GameTeam::class,'category_id');
    }
    public function gameMatch()
    {
        return $this->hasMany(GameMatch::class,'category_id');
    }
    public function gameActiveMatch()
    {
        return $this->hasMany(GameMatch::class,'category_id')->where('status',1);
    }

    public function activeTournament()
    {
        return $this->hasMany(GameTournament::class,'category_id')->where('status',1);
    }
    public function activeTeam()
    {
        return $this->hasMany(GameTeam::class,'category_id')->where('status',1);
    }
    public function activeMatch()
    {
        return $this->hasMany(GameMatch::class,'category_id')->where('status',1);
    }
}
