<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentMedia extends Model
{
    protected $casts = [
        'description' => 'object'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }

}
