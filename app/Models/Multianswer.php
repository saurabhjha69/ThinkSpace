<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Multianswer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    public function answeredMultians(){
        return $this->hasMany(Multians::class);
    }
    public function usersAnswer(){
        return $this->answeredMultians()->where('user_id', Auth::user()->id);
    }
}
