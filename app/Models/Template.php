<?php

namespace App\Models;


use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use Translatable;

    protected $casts = [
        'description' => 'object'
    ];

    public function scopeTemplateMedia()
    {
        $media = TemplateMedia::where('section_name', $this->section_name)->first();
        if (!$media){
            return null;
        }
        return $media->description;
    }




}
