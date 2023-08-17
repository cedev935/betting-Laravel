<?php
namespace App\Models;

use App\Http\Traits\ContentDelete;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use ContentDelete;

    protected $guarded = ['id'];

    public function contentDetails()
    {
        return $this->hasMany(ContentDetails::class, 'content_id', 'id');
    }

    public function language()
    {
        return $this->hasMany(Language::class, 'language_id', 'id');
    }

    public function contentMedia()
    {
        return $this->hasOne(ContentMedia::class, 'content_id', 'id');
    }



}
