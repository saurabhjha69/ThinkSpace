<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function usersAnswer($id){
        return $this->answeredOnelineans()->where('user_id', Auth::user()->id)->where('oneline_id', $id)->first();
    }
}
