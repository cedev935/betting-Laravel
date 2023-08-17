<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NotifyTemplate extends Model
{
    protected $guarded = ['id'];
    protected $table = "notify_templates";

    protected $casts = [
        'short_keys' => 'object'
    ];
    public function language()
    {
        return $this->belongsTo(Language::class,'language_id');
    }
}
