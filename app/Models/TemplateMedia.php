<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateMedia extends Model
{
    protected $casts = [
        'description' => 'object'
    ];
}
