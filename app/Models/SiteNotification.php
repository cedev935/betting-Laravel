<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SiteNotification extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'description' => 'object'
    ];

    protected $appends = ['formatted_date'];

    public function getFormattedDateAttribute(){
        return $this->created_at->format('F d, Y h:i A');
    }

    public function siteNotificational()
    {
        return $this->morphTo();
    }
}
