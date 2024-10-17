<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoStats extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function video(){
        $this->belongsTo(Video::class);
    }
    public function user(){
        $this->belongsTo(User::class,'id','user_id');
    }
}
