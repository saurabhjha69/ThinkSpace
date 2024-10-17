<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oneline extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    public function answeredOnelineans(){
        return $this->hasMany(Onelineans::class);
    }

    public function usersAnswer(){
        return $this->answeredOnelineans()->where('user_id', \Illuminate\Support\Facades\Auth::user()->id);
    }
}
