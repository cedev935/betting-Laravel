<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "kycs";
    protected $casts = [
        'details' => 'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
